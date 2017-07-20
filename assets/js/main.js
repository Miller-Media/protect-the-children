/**
 * Plugin Javascript Module
 *
 * Created     July 19, 2017
 *
 * @package    Protect the Children
 * @author     Matt Miller
 * @since      1.0.0
 */

/**
 * Controller Design Pattern
 *
 * Note: This pattern has a dependency on the "mwp" script
 * i.e. @Wordpress\Script( deps={"mwp"} )
 */
(function( $, undefined ) {
	
	"use strict";

	/**
	 * Main Controller
	 *
	 * The init() function is called after the page is fully loaded.
	 *
	 * Data passed into your script from the server side is available
	 * by the mainController.local property inside your controller:
	 *
	 * > var ajaxurl = mainController.local.ajaxurl;
	 *
	 * The viewModel of your controller will be bound to any HTML structure
	 * which uses the data-view-model attribute and names this controller.
	 *
	 * Example:
	 *
	 * <div data-view-model="millermedia-protectthe">
	 *   <span data-bind="text: title"></span>
	 * </div>
	 */
	var mainController = mwp.controller( 'millermedia-protectthe', 
	{
		
		/**
		 * Initialization function
		 *
		 * @return	void
		 */
		init: function()
		{
			// ajax actions can be made to the ajaxurl, which is automatically provided to your controller
			var ajaxurl = mainController.local.ajaxurl;
			
			// set the properties on your view model which can be observed by your html templates
			mainController.viewModel = 
			{
				title: ko.observable( 'Protect the Children' )
			}
		}
	
	});
		
	
})( jQuery );
 