<?php
/**
 * Plugin Name: Protect the Children!
 * Description: Easily password protect the child pages/posts of a post that is password protected.
 * Version: 1.1
 * Author: Miller Media (Matt Miller)
 * Author URI: www.millermedia.io
 */

if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
    add_action( 'admin_notices', function(){
        echo "<div class=\"error\"><p>".__('Protect the Children requires PHP 5.6 and greater to function properly. Please upgrade PHP or deactivate Protect the Children.', 'protect-the-children') ."</p></div>";
    } );
    return;
}

define('PTC_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PTC_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once(PTC_PLUGIN_PATH . '_inc/helpers.php');

/**
 * Enqueue admin scripts and stylesheets
 *
 * @return void
 */

add_action('admin_enqueue_scripts', function () {

    wp_enqueue_style('ptc-admin–css', PTC_PLUGIN_URL . 'assets/css/admin.css');
    wp_enqueue_script('ptc-admin-js', PTC_PLUGIN_URL . 'assets/js/admin.js');

});

/**
 * Handle new admin option to password protect child posts
 *
 * @return void
 */

add_action('save_post', function ($post_id) {

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $protect_children = isset($_POST['protect-children']) && $_POST['protect-children'] == "on" ? "on" : "off";

    update_post_meta($post_id, '_protect_children', $protect_children);

});

/**
 * Add the option to protect child posts
 *
 * @return void
 */

add_action('post_submitbox_misc_actions', function ($post) {

    $post_type = $post->post_type;

    if (isPasswordProtected($post)) {
        $checked = get_post_meta($post->ID, '_protect_children', true) == "on" ? "checked" : "";
        echo "<div id=\"protect-children-div\"><input type=\"checkbox\" " . $checked . " name=\"protect-children\" /><strong>Password Protect</strong> all child posts</div>";
    }

});

/**
 * On page load, check the post's parent ID
 *
 * @return int
 */

add_action('template_redirect', function () {
    $post_id = get_the_ID();
    $parent_id = wp_get_post_parent_id($post_id);

    if (!$parent_id)
        return;

    // See if the parent post is password protected
    if (!isPasswordProtected($parent_post = get_post($parent_id)))
        return;

    // See if the parent post has the protect child option enabled
    if (empty(get_post_meta($parent_id, '_protect_children', true)) || get_post_meta($parent_id, '_protect_children', true) == "off")
        return;

    $parent_password = $parent_post->post_password;

    // Check the cookie (hashed password)
    require_once ABSPATH . WPINC . '/class-phpass.php';
    $hasher = new PasswordHash( 8, true );
    $hash = wp_unslash( $_COOKIE[ 'wp-postpass_' . COOKIEHASH ] );
    $required = ! $hasher->CheckPassword( $parent_password, $hash );

    // If password has already been entered on the parent post, continue to page
    if( !$required )
        return;

    add_filter('post_password_required', function () {
        return true;
    });

});