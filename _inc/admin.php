<?php

class ProtectTheChildren {

    /**
     * @todo On edit.php page, need to filter only children posts of password protected parents (not all child posts)
     */

    public function __construct()
    {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'save_post', array( $this, 'ptc_save_post_meta' ), 10, 3 );
        add_action( 'post_submitbox_misc_actions', array( $this, 'add_classic_checkbox' ) );
        add_action( 'init', array( $this, 'register_post_meta_gutenberg' ) );
        add_action( 'admin_init', array( $this, 'adjust_visibility' ) );
        add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
        add_filter( 'is_protected_meta', array( $this, 'protect_meta' ), 10, 2 );
        add_filter( 'register_meta_args', array( $this, 'allow_meta_editing_for_admin' ), 10, 4);
    }

    /**
     * Allows users with the 'edit_posts' capability to edit the protected protect_children meta key
     * This is required only when Gutenberg is active.
     *
     * @param $args
     * @param $defaults
     * @param $object_type
     * @param $meta_key
     * @return array
     */
    public function allow_meta_editing_for_admin($args, $defaults, $object_type, $meta_key) {
        if ($meta_key === 'protect_children' && is_array($args)) {
            $args['auth_callback'] = function(){ return current_user_can('edit_posts'); };
        }
        return $args;
    }

    /**
     * Protect the 'protect_children' meta key from begin edited in custom fields
     *
     * @param   bool        $protected              Whether meta key is protected or not
     * @param   string      $meta_key               The meta key being checked
     * @return  bool
     */
    public function protect_meta( $protected, $meta_key ) {
        if ( $meta_key === 'protect_children') {
            return true;
        }

        return $protected;
    }

    /**
     * Enqueue admin scripts and stylesheets
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style( 'ptc-admin–css', PTC_PLUGIN_URL . 'assets/css/admin.css' );

        // load classic editor js if gutenberg is disabled
        if( ! function_exists( 'is_gutenberg_page' ) || ( function_exists( 'is_gutenberg_page' ) && ! is_gutenberg_page() ) ) {
            wp_enqueue_script( 'ptc-admin-js', PTC_PLUGIN_URL . 'assets/js/admin.js' );
        }

    }


    /**
     * Handle admin option to password protect child posts
     *
     * @return void
     */
    public function ptc_save_post_meta( $post_id , $post, $update)
    {
        if( ! ProtectTheChildren_Helpers::supportsPTC( $post ) ) {
            return;
        }

        // When gutenberg is active, some themes such as Jupiter use 
        // old style meta data which is saved in such a way it calls 
        // the save_post hook and runs this method. But on a gutenberg 
        // editor our option is not included as post data, so we need 
        // to return or the setting will always be saved as off
        if ( empty( $_POST) ) {
            add_action( 'rest_after_insert_page', array( $this, 'update_pages_meta' ), 10, 1 );
            return;
        }

        if ( isset( $_GET['meta-box-loader'] ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['protect_children']  ) && $_POST['protect_children'] ) {
            $protect_children = "1";
        } else {
            $protect_children =  "";
        }

        update_post_meta($post_id, 'protect_children', $protect_children);

    }

    /**
     * Add the option to protect child posts - for classic editor
     *
     * @return void
     */
    public function add_classic_checkbox( $post )
    {
        if( ! ProtectTheChildren_Helpers::supportsPTC( $post ) ) {
            return;
        }

        if ( ProtectTheChildren_Helpers::isPasswordProtected( $post ) ) {
            $checked = get_post_meta( $post->ID, 'protect_children', true ) ? "checked" : "";
            echo "<div id=\"protect-children-div\"><input type=\"checkbox\" " . $checked . " name=\"protect_children\" /><strong>Password Protect</strong> all child posts</div>";
        }

    }

    /**
     * Register post meta field for Gutenberg post updates
     *
     * @return void;
     */
    public function register_post_meta_gutenberg()
    {
        register_post_meta('', 'protect_children', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'boolean',
        ));
    }

    /**
     * On admin page load of a child post, change the 'Visibility' for children post if
     * they are protected. There is no hook for that part of the admin section we have
     * to edit the outputted HTML.
     *
     * @param  string $buffer  The outputted HTML of the edit post page
     * @return string $buffer  Original or modified HTML
     */
    public function adjust_visibility( $buffer )
    {
        // Abort on ajax requests
        if ( wp_doing_ajax() ) {
            return;
        }

        global $pagenow;

        // On post list page
        if ( 'edit.php' === $pagenow ) {

            ob_start( function ( $buffer ) {

                // @todo Not working yet below

                // Find children posts
                if ( preg_match_all( '/<tr id="post-(\d*?)".*? level-[12345].*?>/', $buffer, $matches ) ) {

                    if( empty( $matches[1] ) ) {
                        return $buffer;
                    }

                    foreach( $matches[1] as $child_post ) {
                        $parent_post_ids = get_post_ancestors( $child_post );

                        if ( $post_id = ProtectTheChildren_Helpers::isEnabled( $parent_post_ids ) ) {
                            $preg_pattern = sprintf( '/(<\/strong>\n*<div.*?inline_%d">)/i', $child_post );
                            $buffer = preg_replace( $preg_pattern, ' — <span class="post-state">Password protected by parent</span>$1', $buffer );
                        }
                    }

                }

                return $buffer;
            });
        }

        // On single post edit page
        if ( 'post.php' === $pagenow && isset( $_GET['post'] ) ) {
            if( ! ProtectTheChildren_Helpers::supportsPTC( get_post( $_GET['post'] ) ) ){
                return $buffer;
            }

            ob_start( function ( $buffer ) {
                $post = get_post($_GET['post']);

                // Check if it is a child post and if any parent/grandparent post has a password set
                $parent_ids = get_post_ancestors( $post );

                if ( $protected_parent = ProtectTheChildren_Helpers::isEnabled( $parent_ids ) ) {

                    // Change the wording to 'Password Protected' if the post is protected
                    $buffer = preg_replace( '/(<span id="post-visibility-display">)(\n*.*)(<\/span>)/i', '$1Password protected$3', $buffer );

                    // Remove Edit button post visibility (post needs to be updated from parent post)
                    $buffer = preg_replace( '/<a href="#visibility".*?><\/a>/i', '', $buffer );

                    // Add 'Password protect by parent post' notice under visibility section
                    $regex_pattern = '/(<\/div>)(<\!-- \.misc-pub-section -->)(\n*.*)(<div class="misc-pub-section curtime misc-pub-curtime">)/i';
                    $admin_edit_link = sprintf( admin_url( 'post.php?post=%d&action=edit' ), $protected_parent );
                    $update_pattern = sprintf( '<br><span class="wp-media-buttons-icon password-protect-admin-notice">Password protected by <a href="%s">parent post</a></span>$1$2$3$4$5', $admin_edit_link );
                    $buffer = preg_replace( $regex_pattern, $update_pattern, $buffer );
                    
                }

                return $buffer;
            });
        }

    }

    /**
     * Include Gutenberg specific script to add post editor checkbox in post status area.
     *
     * @return void
     */
    public function enqueue_block_editor_assets()
    {
        global $post;
        if( ! ProtectTheChildren_Helpers::supportsPTC( $post ) ) {
            return;
        }

        wp_enqueue_script(
            'ptc-myguten-script',
            PTC_PLUGIN_URL . 'build/index.js',
            array( 'wp-blocks', 'wp-element', 'wp-components' )
        );
    }

    /**
     * Handle admin option to password protect child posts (Gutenberg Editor)
     *
     * @return void
     */

    public function update_pages_meta($post){
        if( ! ProtectTheChildren_Helpers::supportsPTC( $post ) ) {
            return;
        }

        $protect_children = get_post_meta($post->ID, 'protect_children', true);
        update_post_meta($post->ID, 'protect_children', $protect_children);
    }

}
