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
        if ( is_int($post) or !is_object($post) )
            $post = get_post($post);

        return 'private' != $post->post_status && !empty( $post->post_password );

    }

    /**
     * Check if password protected is on and if the Protect the Children option is enabled.
     *
     * @param $post Post ID or post object|Array of Post IDs or post objects
     * @return bool|WP_Post
     */

    static function isEnabled($post)
    {
        if( is_array($post) ) {
            if(empty($post))
                return false;

            foreach ( $post as $single_post ){
                if( $post_protected = self::processPosts($single_post) )
                    return $post_protected->ID;
            }
        }

        if( $post_protected = self::processPosts($post) )
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
        if ( is_array($post) ){
            foreach($post as $post_id){
                if( $process_post = self::processPost($post_id) ){
                    return $process_post;
                }
            }
        } else {
            return self::processPost($post);
        }

        return false;
    }

    static function processPost($post_id){
        if ( is_int($post_id) or !is_object($post_id) )
            $post = get_post($post_id);

        if( !$post )
            return false;

        if ( !self::isPasswordProtected($post) )
            return false;

        if ( get_post_meta($post->ID, 'protect_children', true)  )
            return $post;
    }

    /**
     * Check if post can support Protect the Children
     *
     * @param $post
     * @return bool|WP_Post
     */
    static function supportsPTC($post){
        $post_type = $post->post_type;

        if( is_post_type_hierarchical( $post_type ) && post_type_supports( $post_type, 'custom-fields') ){
            return true;
        }

        return false;
    }

}