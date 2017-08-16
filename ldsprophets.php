<?php
/**
 * @package ldsprophets
 * @version 1.0
 */
/*
Plugin Name: LDS Prophets Functionality Plugin
Plugin URI: http://app.circlcube.com/lds-prophets
Description: Functionality for LDS Prophets App
Author: Evan Mullins
Version: 1.0
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

	// Hook to add preexisting custom taxonomies to rest api response via plugin
	// https://developer.wordpress.org/rest-api/extending-the-rest-api/modifying-responses/
	add_action( 'init', 'my_custom_taxonomy_rest_support', 25 );
	function my_custom_taxonomy_rest_support() {
		global $wp_taxonomies;

        //Here should be a list of names of the already created custom taxonomies:
        $taxonomy_names = array(
            'types',
            'prophet'
        );
        foreach ( $taxonomy_names as $key => $taxonomy_name ) {
            if (isset($wp_taxonomies[$taxonomy_name])) {
                $wp_taxonomies[$taxonomy_name]->show_in_rest = true;
                $wp_taxonomies[$taxonomy_name]->rest_base = $taxonomy_name;
                $wp_taxonomies[$taxonomy_name]->rest_controller_class = 'WP_REST_Terms_Controller';
            }
        }
    }
	
?>