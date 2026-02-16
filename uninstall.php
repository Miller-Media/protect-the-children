<?php
/**
 * Uninstall handler for Protect the Children.
 *
 * @package Protect_The_Children
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$delete_data = get_option( 'ptc_delete_data_on_uninstall' );

if ( ! $delete_data ) {
	return;
}

// Delete plugin options.
delete_option( 'PTC_plugin_version' );
delete_option( 'ptc_activated_on' );
delete_option( 'ptc_delete_data_on_uninstall' );

// Clean up post meta.
global $wpdb;
$wpdb->delete( $wpdb->postmeta, array( 'meta_key' => 'protect_children' ) );

// Clean up user meta for review notice dismissals.
$wpdb->delete( $wpdb->usermeta, array( 'meta_key' => 'protect-the-children_review_dismissed' ) );
