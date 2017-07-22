<?php
/**
 * @package ldsprophets
 * @version 1.0.0
 */
/*
Plugin Name: LDS Prophets Functionality Plugin
Plugin URI: http://app.circlcube.com/lds-prophets
Description: Functionality for LDS Prophets App
Author: Evan Mullins
Version: 1.0.0
GitHub Plugin URI: https://github.com/circlecube/ldsprophets-plugin
*/


	
	

	//  load custom js for data entry helper
	// Register Script
	function ldsprophets_scripts() {
		// if( $hook != 'edit.php' ) 
				// return;
		 
			wp_enqueue_script( 'ldsprophets_js', plugins_url( 'ldsprophets/js/script.js' , dirname(__FILE__) ), array('jquery'), '20150605' );
			
	}
	// Hook into the 'admin_enqueue_scripts' action
	add_action( 'admin_enqueue_scripts', 'ldsprophets_scripts' );
	
	//load custom css for admin style tweaks
	function ldsprophets_styles() {
		// wp_enqueue_style( 'ldsprophets_css', plugins_url( 'ldsprophets/css/styles.css', dirname(__FILE__) ) );
	}
	//add_action( 'admin_enqueue_scripts', 'ldsprophets_styles' );

	
?>
