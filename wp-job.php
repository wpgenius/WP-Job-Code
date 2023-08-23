<?php

/*
Plugin Name: WP Job Code
Plugin URI: https://wpgenius.in
Description: WP Job is a simole plugin to post jobs.
Version: 1.0
Author: Team WPgenius
Author URI: http://wpgenius.in/
Text Domain: wp-job
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'WP_JOB_DIR_PATH', plugin_dir_path( __FILE__ ) );

require_once WP_JOB_DIR_PATH . 'include/plugin-actions.php';

require_once WP_JOB_DIR_PATH . 'include/shortcode/job-list.php';


function load_plugin_css() {
		wp_enqueue_style( 'wp-job-css', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'load_plugin_css' );


add_action( 'init', 'create_wp_jobs' );
function create_wp_jobs() {

	$labels = array(
		'name'           => _x( 'Jobs', 'Post Type General Name', 'wp-job' ),
		'singular_name'  => _x( 'Job', 'Post Type Singular Name', 'wp-job' ),
		'menu_name'      => __( 'Jobs', 'wp-job' ),
		'name_admin_bar' => __( 'Jobs', 'wp-job' ),
		'all_items'      => __( 'All Jobs', 'wp-job' ),
		'add_new_item'   => __( 'Add New Job', 'wp-job' ),
		'new_item'       => __( 'New Job', 'wp-job' ),
		'edit_item'      => __( 'Edit Job', 'wp-job' ),
		'update_item'    => __( 'Update Job', 'wp-job' ),
		'view_item'      => __( 'View Job', 'wp-job' ),
		'search_items'   => __( 'Search Job', 'wp-job' ),
		'add_title'      => __( 'Add Job Title', 'wp-job' ),

	);
	$args = array(
		'labels'              => $labels,
		'description'         => __( 'Holds jobs and job specific data', 'wp-job' ),
		'hierarchical'        => false,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-portfolio',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => array( 'slug' => 'jobs' ),
		'capability_type'     => 'post',
		'supports'            => array( 'title', 'editor' ),

	);
	register_post_type( 'wp_jobs', $args );

	$singular   = 'Job Type';
	$plural     = 'Job Types';
	$tax_labels = array(
		'name'          => _x( $plural, 'taxonomy general name' ),
		'singular_name' => _x( $singular, 'taxonomy singular name' ),
		'search_items'  => __( "Search $singular" ),
		'all_items'     => __( "All $singular" ),
		'edit_item'     => __( "Edit $singular" ),
		'update_item'   => __( "Update $singular" ),
		'add_new_item'  => __( "Add New $singular" ),
		'new_item_name' => __( "New $singular Name" ),
	);

	register_taxonomy(
		'wp_job_type',
		'wp_jobs',
		array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_nav_menus'  => true,
			'hierarchical'       => false,
			'query_var'          => true,
			'rewrite'            => false,
			'labels'             => $tax_labels,
		)
	);

	$singular   = 'Job Category';
	$plural     = 'Job Categories';
	$tax_labels = array(
		'name'          => _x( $plural, 'taxonomy general name' ),
		'singular_name' => _x( $singular, 'taxonomy singular name' ),
		'search_items'  => __( "Search $singular" ),
		'all_items'     => __( "All $singular" ),
		'edit_item'     => __( "Edit $singular" ),
		'update_item'   => __( "Update $singular" ),
		'add_new_item'  => __( "Add New $singular" ),
		'new_item_name' => __( "New $singular Name" ),
	);

	register_taxonomy(
		'wp_job_cat',
		'wp_jobs',
		array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_nav_menus'  => true,
			'hierarchical'       => false,
			'query_var'          => true,
			'rewrite'            => false,
			'labels'             => $tax_labels,
		)
	);

}

/**
 * Activate the plugin.
 */
function plugin_wp_job_activate() {
	// Trigger our function that registers the custom post type plugin.
	create_wp_jobs();
	// Clear the permalinks after the post type has been registered.
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'plugin_wp_job_activate' );

/**
 * Deactivation hook.
 */
function plugin_wp_job_deactivate() {
	// Unregister the post type, so the rules are no longer in memory.
	unregister_post_type( 'wp_jobs' );
	// Clear the permalinks to remove our post type's rules from the database.
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'plugin_wp_job_deactivate' );
