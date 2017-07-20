<?php
/**
 * Plugin Class File
 *
 * @vendor: Miller Media
 * @package: Protect the Children
 * @author: Matt Miller
 * @link: 
 * @since: July 19, 2017
 */
namespace MillerMedia\ProtectThe;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

/**
 * Plugin Class
 */
class Plugin extends \Modern\Wordpress\Plugin
{
	/**
	 * Instance Cache - Required
	 * @var	self
	 */
	protected static $_instance;
	
	/**
	 * @var string		Plugin Name
	 */
	public $name = 'Protect the Children';
	
	/**
	 * Main Stylesheet
	 *
	 * @Wordpress\Stylesheet
	 */
	public $mainStyle = 'assets/css/style.css';

	/**
	 * Admin Stylesheet
	 *
	 * @Wordpress\Stylesheet
	 */
	public $adminStyle = 'assets/css/admin.css';
	
	/**
	 * Main Javascript Controller
	 *
	 * @Wordpress\Script( deps={"mwp"} )
	 */
	public $mainScript = 'assets/js/main.js';

	/**
	 * Admin Javascript Controller
	 *
	 * @Wordpress\Script( deps={"jquery"} )
	 */
	public $adminScript = 'assets/js/admin.js';
	
	/**
	 * Enqueue scripts and stylesheets
	 * 
	 * @Wordpress\Action( for="wp_enqueue_scripts" )
	 *
	 * @return	void
	 */
	public function enqueueScripts()
	{
		$this->useStyle( $this->mainStyle );
		$this->useScript( $this->mainScript );
	}
	
	/**
	 * Enqueue admin scripts and stylesheets
	 *
	 * @Wordpress\Action( for="admin_enqueue_scripts" )
	 *
	 * @return void
	 */
	public function adminEnqueue()
	{
		$this->useStyle( $this->adminStyle );
		$this->useScript( $this->adminScript );
	}

	/**
	 * Check if post is password protected
	 *
	 * @return boolean
	 */

	public function isPasswordProtected( $post ){

		return 'private' != $post->post_status && !empty( $post->post_password );

	}

	/**
	 * Handle new admin option to password protect child posts
	 *
	 * @Wordpress\Action( for="save_post" )
	 *
	 * @return void
	 */
	public function saveProtectChildOption( $post_id )
	{

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( !current_user_can( 'edit_post', $post_id ) )
			return;

		$protect_children = isset($_POST['protect-children']) && $_POST['protect-children']=="on" ? "on" : "off";

		update_post_meta( $post_id, '_protect_children', $protect_children );

	}

	/**
	 * Add the option to protect child posts
	 *
	 * @Wordpress\Action( for="post_submitbox_misc_actions" )
	 *
	 * @return void
	 */
	public function addCheckboxToMeta( $post )
	{
		$post_type = $post->post_type;

		if ( $this->isPasswordProtected( $post ) ) {
			$checked = get_post_meta( $post->ID, '_protect_children', true )=="on" ? "checked" : "";
			echo "<div id=\"protect-children-div\"><input type=\"checkbox\" ".$checked." name=\"protect-children\" /><strong>Password Protect</strong> all child posts</div>";
		}

	}

	/**
	 * On page load, check the post's parent ID
	 *
	 * @WordPress\Action( for="template_redirect" )
	 *
	 * @return int
	 */
	public function getParentID()
	{
		$post_id = get_the_ID();
		$parent_id = wp_get_post_parent_id( $post_id );


		if( !$parent_id )
			return;

		// See if the parent post is password protected
		if( !$this->isPasswordProtected( get_post( $parent_id ) ) )
			return;

		// See if the parent post has the protect child option enabled
		if( empty( get_post_meta( $parent_id, '_protect_children', true ) ) || get_post_meta( $parent_id, '_protect_children', true ) == "off" )
			return;

		add_filter('post_password_required', function(){ return true; });

	}

}