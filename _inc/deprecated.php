<?php

/*
Deprecated functions moved to class.
These functions may be removed in a future version.
*/

// Based on WP core `_deprecated_function()`
function _ptc_deprecated_warning( $function, $version, $replacement = null ) {

    do_action( 'deprecated_function_run', $function, $replacement, $version );

	if ( WP_DEBUG && apply_filters( 'deprecated_function_trigger_error', true ) ) {
		if ( ! is_null( $replacement ) ) {
			trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.', $function, $version, $replacement ) );
		} else {
			trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.', $function, $version ) );
		}
	}

}

if ( !function_exists( 'isPasswordProtected' ) ) {

	function isPasswordProtected( $post ) {
		_ptc_deprecated_warning( __FUNCTION__, '1.3.4', 'ProtectTheChildren_Helpers::isPasswordProtected' );
		ProtectTheChildren_Helpers::isPasswordProtected( $post );
	}

}

if ( !function_exists( 'protectTheChildrenEnabled' ) ) {

	function protectTheChildrenEnabled( $post ) {
		_ptc_deprecated_warning( __FUNCTION__, '1.3.4', 'ProtectTheChildren_Helpers::isEnabled' );
		ProtectTheChildren_Helpers::isEnabled( $post );
	}

}

if ( !function_exists( 'processPosts' ) ) {

	function processPosts( $post ) {
		_ptc_deprecated_warning( __FUNCTION__, '1.3.4', 'ProtectTheChildren_Helpers::processPosts' );
		ProtectTheChildren_Helpers::processPosts( $post );
	}

}