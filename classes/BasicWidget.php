<?php
/**
 * Widget Class File
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
 * Widget Class
 */
class BasicWidget extends \Modern\Wordpress\Plugin\Widget
{
 	/**
	 * @var	Plugin (Do Not Remove)
	 */
	protected static $plugin;
	
	/**
	 * Widget Name
	 *
	 * @var	string
	 */
	public $name = 'Protect the Children Widget';
	
	/**
	 * Widget Description
	 *
	 * @var	string
	 */
	public $description = 'An example modern wordpress widget';
	
	/**
	 * Widget Settings
	 *
	 * @var	array
	 */
	public $settings = array
	(
		'title' 	=> array( 'title' => 'Widget Title', 'type' => 'text', 'default' => 'Protect the Children Widget' ),
		'content' 	=> array( 'title' => 'Widget Content', 'type' => 'textarea' ),
	);

	/**
	 * HTML Wrapper Class
	 * 
	 * @var string
	 */
	public $classname = 'millermedia-protectthe-widget';
	
	/**
	 * Output the widget content.
	 *
	 * @param 	array 	$args     	Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param 	array 	$instance 	The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) 
	{
		echo $this->getPlugin()->getTemplateContent( 'widget/layout/standard', array( 'args' => $args, 'widget_title' => $instance[ 'title' ], 'widget_content' => $instance[ 'content' ] ) );
	}
	
}