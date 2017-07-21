<?php

/**
 * Check if post is password protected
 *
 * @return boolean
 */

function isPasswordProtected($post)
{

    return 'private' != $post->post_status && !empty($post->post_password);

}