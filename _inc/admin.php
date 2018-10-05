<?php

/**
 * @todo Convert this code into a class
 * @todo On edit.php page, need to filter only children posts of password protected parents (not all child posts)
 */

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
 * On admin page load of a child post, change the 'Visibility' for children post if
 * they are protected. There is no hook for that part of the admin section we have
 * to edit the outputted HTML.
 *
 * @param string $buffer The outputted HTML of the edit post page
 * @return string $buffer   Original or modified HTML
 */

add_action('admin_init', function () {
    // Abort on ajax requests
    if (wp_doing_ajax())
        return;

    global $pagenow;

    // On post list page
    if ('edit.php' === $pagenow) {
        ob_start(function ($buffer) {

            // @todo Not working yet below

            // Find children posts
            if (preg_match_all('/(<tr id="post-)(\d*?)(".*? level-1.*?>)/', $buffer, $matches)) {

                $child_post_id = $matches[2];
                $parent_post_id = wp_get_post_parent_id($child_post_id);

                // Check if child post is protected
                if (protectTheChildrenEnabled($parent_post_id)) {
                    $preg_pattern = sprintf('/(<\/strong>\n*<div.*?inline_%d">)/i', $child_post_id);
                    $buffer = preg_replace($preg_pattern, ' — <span class="post-state">Password protected by parent</span>$1', $buffer);
                }

            }

            return $buffer;

        });
    }

    // On single post edit page
    if ('post.php' === $pagenow && isset($_GET['post'])) {
        ob_start(function ($buffer) {

            $post = get_post($_GET['post']);

            // Check if it is a child post and if any parent/grandparent post has a password set
            $parent_ids = get_post_ancestors($post);

            if ($protected_parent = protectTheChildrenEnabled($parent_ids)) {

                // Change the wording to 'Password Protected' if the post is protected
                $buffer = preg_replace('/(<span id="post-visibility-display">)(.*)(<\/span>)/i', '$1Password protected$3', $buffer);

                // Remove Edit button post visibility (post needs to be updated from parent post)
                $buffer = preg_replace('/<a href="#visibility".*?><\/a>/i', '', $buffer);

                // Add 'Password protect by parent post' notice under visibility section
                $regex_pattern = '/(<\/div>)(\n*|.*)(<\!-- \.misc-pub-section -->)(\n*|.*)(<div class="misc-pub-section curtime misc-pub-curtime">)/i';
                $admin_edit_link = sprintf(admin_url('post.php?post=%d&action=edit'), $protected_parent);
                $update_pattern = sprintf('<br><span class="wp-media-buttons-icon password-protect-admin-notice">Password protected by <a href="%s">parent post</a></span>$1$2$3$4$5', $admin_edit_link);
                $buffer = preg_replace($regex_pattern, $update_pattern, $buffer);
            }

            return $buffer;
        });
    }
});