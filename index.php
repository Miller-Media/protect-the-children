<?php
/**
 * Plugin Name: Protect the Children!
 * Description: Easily password protect the child pages/posts of a post that is password protected.
 * Version: 1.2
 * Author: Miller Media (Matt Miller)
 * Author URI: www.millermedia.io
 */

if (version_compare(PHP_VERSION, '5.6', '<')) {
    add_action('admin_notices', function () {
        echo "<div class=\"error\"><p>" . __('Protect the Children requires PHP 5.6 and greater to function properly. Please upgrade PHP or deactivate Protect the Children.', 'protect-the-children') . "</p></div>";
    });
    return;
}

define('PTC_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PTC_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once(PTC_PLUGIN_PATH . '_inc/helpers.php');
require_once(PTC_PLUGIN_PATH . '_inc/admin.php');

/**
 * On front-end page load, check the post's parent ID
 *
 * @return bool
 */

add_action('template_redirect', function () {
    $post_id = get_the_ID();
    $parent_id = wp_get_post_parent_id($post_id);

    if (!$parent_id)
        return;

    $parent_post = protectTheChildrenEnabled($parent_id);

    if (!$parent_post)
        return;

    $parent_password = $parent_post->post_password;

    // Check the cookie (hashed password)
    require_once ABSPATH . WPINC . '/class-phpass.php';
    $hasher = new PasswordHash(8, true);
    $hash = wp_unslash($_COOKIE['wp-postpass_' . COOKIEHASH]);
    $required = !$hasher->CheckPassword($parent_password, $hash);

    // If password has already been entered on the parent post, continue to page
    if (!$required)
        return;

    add_filter('post_password_required', function () {
        return true;
    });

});