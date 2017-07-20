<?php
/**
 * Settings Class File
 *
 * @vendor: Miller Media
 * @package: Protect the Children
 * @author: Matt Miller
 * @link: 
 * @since: July 19, 2017
 */
namespace MillerMedia\ProtectThe;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

/**
 * Plugin Settings
 *
 * @Wordpress\Options
 * @Wordpress\Options\Section( title="General Settings" )
 * @Wordpress\Options\Field( name="setting1", type="text", title="Setting 1" )
 * @Wordpress\Options\Field( name="setting2", type="select", title="Setting 2", options={ "opt1":"Option1", "opt2": "Option2" } )
 * @Wordpress\Options\Field( name="setting3", type="select", title="Setting 3", options="optionsCallback" )
 */
class Settings extends \Modern\Wordpress\Plugin\Settings
{
	/**
	 * Instance Cache - Required for singleton
	 * @var	self
	 */
	protected static $_instance;
	
	/**
	 * @var string	Settings Access Key ( default: main )
	 */
	public $key = 'main';
	
	/**
	 * Example Options Generator
	 * @see: class annotation for setting3
	 *
	 * @param		mixed			$currentValue				Current settings value
	 * @return		array
	 */ 
	public function optionsCallback( $currentValue )
	{
		return array
		(
			'opt3' => 'Option 3',
			'opt4' => 'Option 4',
		);
	}
		
}