<?php

class ProtectTheChildren_Helpers {
    /**
     * Checks if post is password protected
     *
     * @param int|object $post
     * @return boolean
     */

    static function isPasswordProtected($post)
    {
        if (is_int($post) or !is_object($post))
            $post = get_post($post);

        return 'private' != $post->post_status && !empty($post->post_password);

    }

    /**
     * Check if password protected is on and if the Protect the Children option is enabled.
     *
     * @param $post Post ID or post object|Array of Post IDs or post objects
     * @return bool|WP_Post
     */

    static function isEnabled($post)
    {
        if(is_array($post)) {
            if(empty($post))
                return false;

            foreach ($post as $single_post){
                if($post_protected = self::processPosts($single_post))
                    return $post_protected->ID;
            }
        }

        if($post_protected = self::processPosts($post))
            return $post_protected->ID;
    }

    /**
     * Process the post objects for protectTheChildrenEnabled function
     *
     * @param $post
     * @return bool|WP_Post
     */
    static function processPosts($post)
    {
        if (is_int($post) or !is_object($post))
            $post = get_post($post);

        if (!self::isPasswordProtected($post))
            return false;

        if ( get_post_meta($post->ID, 'protect_children', true)  )
            return $post;

        return false;
    }

}