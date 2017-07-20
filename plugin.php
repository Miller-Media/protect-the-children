<?php
/**
 * Plugin Name: Protect the Children
 * Depends: lib-modern-framework
 * Description: Easily password protect the child pages/posts of a post that is password protected.
 * Version: 0.0.0
 * Author: Miller Media (Matt Miller)
 * Author URI: www.millermedia.io
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

/* Load Only Once */
if ( ! class_exists( 'MillerMediaProtectThePlugin' ) )
{
	class MillerMediaProtectThePlugin
	{
		public static function init()
		{
			/* Plugin Core */
			$plugin	= \MillerMedia\ProtectThe\Plugin::instance();
			$plugin->setPath( rtrim( plugin_dir_path( __FILE__ ), '/' ) );
			
			/* Plugin Settings */
			$settings = \MillerMedia\ProtectThe\Settings::instance();
			$plugin->addSettings( $settings );
			
			/* Connect annotated resources to wordpress core */
			$framework = \Modern\Wordpress\Framework::instance()
				->attach( $plugin )
				->attach( $settings )
				;
			
			/* Enable Widgets */
			\MillerMedia\ProtectThe\BasicWidget::enableOn( $plugin );
		}
		
		public static function status() {
			if ( ! class_exists( 'ModernWordpressFramework' ) ) {
				echo '<td colspan="3" class="plugin-update colspanchange">
						<div class="update-message notice inline notice-error notice-alt">
							<p><strong style="color:red">INOPERABLE.</strong> Please activate <a href="' . admin_url( 'plugins.php?page=tgmpa-install-plugins' ) . '"><strong>Modern Framework for Wordpress</strong></a> to enable the operation of this plugin.</p>
						</div>
					  </td>';
			}
		}
	}
	
	/* Autoload Classes */
	require_once 'vendor/autoload.php';
	
	/* Bundled Framework */
	if ( file_exists( __DIR__ . '/framework/plugin.php' ) ) {
		include_once 'framework/plugin.php';
	}

	/* Register plugin dependencies */
	include_once 'includes/plugin-dependency-config.php';
	
	/* Register plugin status notice */
	add_action( 'after_plugin_row_' . plugin_basename( __FILE__ ), array( 'MillerMediaProtectThePlugin', 'status' ) );
	
	/**
	 * DO NOT REMOVE
	 *
	 * This plugin depends on the modern wordpress framework.
	 * This block ensures that it is loaded before we init.
	 */
	if ( class_exists( 'ModernWordpressFramework' ) ) {
		MillerMediaProtectThePlugin::init();
	}
	else {
		add_action( 'modern_wordpress_init', array( 'MillerMediaProtectThePlugin', 'init' ) );
	}
	
}

