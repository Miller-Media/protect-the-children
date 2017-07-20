<?php
/**
 * Plugin HTML Template
 *
 * Created:  July 19, 2017
 *
 * @package  Protect the Children
 * @author   Matt Miller
 * @since    1.0.0
 *
 * Here is an example of how to get the contents of this template while 
 * providing the values of the $title and $content variables:
 * ```
 * $content = $plugin->getTemplateContent( 'snippet', array( 'title' => 'Some Custom Title', 'content' => 'Some custom content' ) ); 
 * ```
 * 
 * @param	Plugin		$this		The plugin instance which is loading this template
 *
 * @param	string		$title		The provided title
 * @param	string		$content	The provided content
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

?>

<!-- html content -->
<h2><?php echo $title ?></h2>
<div>
	<?php echo $content ?>
</div>