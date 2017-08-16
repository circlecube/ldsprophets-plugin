<?php
/**
 * @package ldsprophets
 * @version 1.1.0
 */
/*
Plugin Name: LDS Prophets Functionality Plugin
Plugin URI: https://circlcube.com/lds-prophets/
Description: Functionality for LDS Prophets App
Author: Evan Mullins
Version: 1.1.0
GitHub Plugin URI: https://github.com/circlecube/ldsprophets-plugin
*/


	
	

	//  load custom js for data entry helper
	// Register Script
	function ldsprophets_scripts() {
		// if( $hook != 'edit.php' ) 
				// return;
		 
			wp_enqueue_script( 'ldsprophets_js', plugin_dir_url( __FILE__ ) . 'js/script.js', array('jquery'), '20150605' );
			
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
	
    // Add lds-leaders/v1/all-leaders/ route
    function cclds_register_api_hooks(){

	    register_rest_route( 'lds-leaders/v1', '/all-leaders/', array(
	        'methods' => 'GET',
	        'callback' => 'cclds_get_all_leaders',
	    ) );
	}

    add_action( 'rest_api_init', 'cclds_register_api_hooks' );

    function cclds_get_all_leaders(){
    	// delete_transient('cclds_all_leaders');
    	// Return all leader posts IDs
        if ( false === ( $json = get_transient( 'cclds_all_leaders' ) ) ) {
        	
        	$leaders = [];

        	$leader_args = array(
        		'post_type' => 'leader',
        		'posts_per_page' => -1,
            	'orderby' => 'meta_value',
            	'meta_key' => 'ordained_date'
        	);
        	$leader_query = new WP_Query( $leader_args );
        	// The Loop
        	if ( $leader_query->have_posts() ) {
        		while ( $leader_query->have_posts() ) {
        			$leader_query->the_post();
        			
        			//IMG
        			$attachment_id = get_post_thumbnail_id( get_the_ID() );
        			$image_attributes = wp_get_attachment_image_src( $attachment_id, 'large' ); // returns an array
        			$img = $image_attributes[0];
        			
        			//main
        			$main_image = get_field('main_image');
        			$youth_image = get_field('youth_image');
        			
        			//Group
        			$leader_group_terms = get_the_terms( get_the_ID(), 'types');
        			$leader_group = [];
        			foreach ( $leader_group_terms as $term ) {
        				$leader_group[] = $term->name;
        			}
        			$groups = implode(",", $leader_group);
        			
        			$prophet_group_terms = get_the_terms( get_the_ID(), 'prophet');
        			$prophet_group = [];
        			foreach ( $prophet_group_terms as $term ) {
        				$prophet_group[] = $term->name;
        			}
        			$served_with = implode(",", $prophet_group);
        			
        			$leader = (object)[];

        			$leader->id = get_the_ID();
        			$leader->name = the_title(null,null,false);
        			$leader->first_name = get_field('first_name');
        			$leader->middle_name = get_field('middle_name');
        			$leader->last_name = get_field('last_name');
        			$leader->initial = get_field('initial');
        			$leader->position = get_field('position');
        			$leader->birthdate = get_field('birthdate');
        			$leader->ordained_date = get_field('ordained_date');
        			$leader->ordinal = get_field('quorum_seniority');
        			$leader->order = get_field('quorum_seniority');
        			$leader->deathdate = get_field('death_date');
        			$leader->hometown = get_field('hometown');
        			$leader->conference_talks = get_field('conference_talks');
        			$leader->profession = get_field('profession');
        			$leader->military = get_field('military');
        			$leader->education = get_field('education');
        			$leader->mission = get_field('mission');
        			$leader->reason_called = get_field('reason_called');
        			$leader->img = $main_image['sizes']['medium'];
        			$leader->img2 = $youth_image['sizes']['medium'];
        			$leader->groups = $groups;
        			$leader->served_with = $served_with;

        			array_push($leaders, $leader);
        			
        		} // end while 
        	}// end loop if
        		
        	wp_reset_query();

        	// $json = json_encode($leaders);
        	$json = $leaders;

        	set_transient( 'cclds_all_leaders', $json, WEEK_IN_SECONDS );
        }

        return $json;
    }
?>