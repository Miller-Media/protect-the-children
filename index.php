<?php
/**
 * Plugin Name: Protect the Children!
 * Description: Easily password protect the child pages/posts of a post that is password protected.
 * Version: 1.3.6
 * Author: Miller Media (Matt Miller)
 * Author URI: www.millermedia.io
 */


if ( ! defined( 'PROTECT_THE_CHILDREN_PLUGIN_VERSION' ) ) {
    define( 'PROTECT_THE_CHILDREN_PLUGIN_VERSION', '1.3.4' );
}

if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
    add_action( 'admin_notices', function () {
        echo "<div class=\"error\"><p>" . __('Protect the Children requires PHP 5.6 and greater to function properly. Please upgrade PHP or deactivate Protect the Children.', 'protect-the-children') . "</p></div>";
    } );
    return;
}

define( 'PTC_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'PTC_PLUGIN_URL', plugin_dir_url(__FILE__) );

require_once( PTC_PLUGIN_PATH . '_inc/helpers.php' );
require_once( PTC_PLUGIN_PATH . '_inc/admin.php' );
require_once( PTC_PLUGIN_PATH . '_inc/deprecated.php' );

new ProtectTheChildren();

/**
 * On front-end page load, check the post's parent ID
 *
 * @return bool
 */

add_action( 'template_redirect', function () {
    $post_id = get_the_ID();
    $parent_ids = get_post_ancestors( $post_id );

    if ( ! $parent_ids || empty( $parent_ids ) ) {
        return;
    }

    $parent_post = ProtectTheChildren_Helpers::isEnabled( $parent_ids );

    if ( ! $parent_post ) {
        return;
    }

    $parent_post_object = is_int( $parent_post ) ? get_post( $parent_post ) : $parent_post;
    $parent_password = $parent_post_object->post_password;

    // Check the cookie (hashed password)
    require_once ABSPATH . WPINC . '/class-phpass.php';
    $hasher = new PasswordHash( 8, true );
    $hash = wp_unslash( $_COOKIE['wp-postpass_' . COOKIEHASH] );
    $required = ! $hasher->CheckPassword( $parent_password, $hash );

    // If password has already been entered on the parent post, continue to page
    if ( ! $required ) {
        return;
    }

    add_filter( 'post_password_required', function () {
        return true;
    } );

} );

/**
 * Upgrade meta key for older versions
 */
function PTC_update_db_check() {

    if ( get_option( 'PTC_plugin_version', '' ) != PROTECT_THE_CHILDREN_PLUGIN_VERSION ) {

        $password_pages = get_pages( array( 'meta_key' => '_protect_children', 'meta_value' => 'on' ) );

        foreach( $password_pages as $page ) { 
            update_post_meta( $page->ID, 'protect_children', '1' );
            delete_post_meta( $page->ID, '_protect_children' );
        }   
    }

    update_option( 'PTC_plugin_version', PROTECT_THE_CHILDREN_PLUGIN_VERSION );
}
add_action( 'plugins_loaded', 'PTC_update_db_check' );

/**
 * Set version number and check for updates if necessary, on activation
 */
register_activation_hook( __FILE__, 'PTC_update_db_check' );
