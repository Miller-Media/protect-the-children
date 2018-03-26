<?php

/**
 * @todo Convert this code into a class
 */

/**
 * Checks if post is password protected
 *
 * @param int|object $post
 * @return boolean
 */

function isPasswordProtected($post)
{
    if (is_int($post) or !is_object($post))
        $post = get_post($post);

    return 'private' != $post->post_status && !empty($post->post_password);

}

/**
 * Check if password protected is on and if the Protect the Children option is enabled.
 *
 * @param $post Post ID or post object
 * @return bool|WP_Post
 */

function protectTheChildrenEnabled($post)
{
    if (is_int($post) or !is_object($post))
        $post = get_post($post);

    if (!isPasswordProtected($post))
        return false;

    if ( get_post_meta($post->ID, '_protect_children', true) == "on" )
        return $post;

    return false;
}