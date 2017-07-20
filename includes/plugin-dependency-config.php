<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

include_once 'class-tgm-plugin-activation.php';

/* Register dependencies for this plugin */
add_action( 'tgmpa_register', function() 
{
	$base_dir = dirname( dirname( __FILE__ ) );
	$dependencies = array();
	
	if ( file_exists( $base_dir . '/data/plugin-dependencies.php' ) )
	{
		$plugin_dependencies = json_decode( include $base_dir . '/data/plugin-dependencies.php', TRUE );
		$dependencies = array_merge( $dependencies, $plugin_dependencies );
	}
	
	$plugin_name = 'An active plugin';
	if ( file_exists( $base_dir . '/data/plugin-meta.php' ) )
	{
		$plugin_meta = json_decode( include $base_dir . '/data/plugin-meta.php', TRUE );
		$plugin_name = $plugin_meta[ 'name' ];
	}
	
	$config = array(
		'id'           => basename( $base_dir ),
		'default_path' => $base_dir . '/bundles',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'plugins.php',
		'capability'   => 'manage_options',
		'has_notices'  => true,
		'dismissable'  => false,
		'is_automatic' => true,
		'strings'      => array(
			'notice_can_install_required'     => _n_noop(
				'<em>' . $plugin_name . '</em> requires the following plugin: %1$s.',
				'<em>' . $plugin_name . '</em> requires the following plugins: %1$s.',
				basename( $base_dir )
			),
			'notice_can_install_recommended'  => _n_noop(
				'<em>' . $plugin_name . '</em> recommends the following plugin: %1$s.',
				'<em>' . $plugin_name . '</em> recommends the following plugins: %1$s.',
				basename( $base_dir )
			),
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with <em>' . $plugin_name . '</em>: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with <em>' . $plugin_name . '</em>: %1$s.',
				basename( $base_dir )
			),
		),
	);
	
	/* Register dependencies */
	tgmpa( $dependencies, $config );
});
