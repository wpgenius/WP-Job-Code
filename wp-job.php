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

define( 'WP_JOB_DIR_URL', plugin_dir_url( __FILE__ ) );

require_once WP_JOB_DIR_PATH . 'include/plugin-actions.php';

require_once WP_JOB_DIR_PATH . 'include/shortcode/job-list.php';


function load_plugin_css() {
		wp_enqueue_style( 'wp-job-css', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
		wp_register_script( 'jc-isotop' , plugin_dir_url( __FILE__ ). 'assets/js/isotope.min.js', array('jquery'), 1.0, true);
		wp_register_script( 'jc-custom' , plugin_dir_url( __FILE__ ). 'assets/js/customscript.js', array('jc-isotop'), 1.0, true);
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
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => array( 'slug' => 'jobs' ),
		'capability_type'     => 'post',
		'support'            => array( 'title', 'editor' ),

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
			'hierarchical'       => true,
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


function wp_job_meta_box() {
	add_meta_box( 'job-meta', __( 'Job details' , 'altiushub' ),  'wp_job_post_meta_callback' , 'wp_jobs', 'advanced', 'high' );
}
add_action( 'add_meta_boxes', 'wp_job_meta_box');

/**
 * Add post meta boxes to post type
 *
 * @param object $post
 * @return void
 */
function wp_job_post_meta_callback( $post ) {

	$job_experience = get_post_meta( $post->ID, 'job_experience', true ); 
	$job_qualification = get_post_meta( $post->ID, 'job_qualification', true ); ?>

	<div class="form-wrap">
		<div class="class-row">
			<div class="left">
				<label for="job_experience"><?php _e( 'Experience required', 'altiushub' ); ?></label>
			</div>
			<div class="right">
				<input style="width:100%; padding:10px !important;" type="text" id="job_experience" name="job_experience" value="<?php echo $job_experience; ?>" />
			</div>
		</div>
		
		<div class="class-row">
			<div class="left">
				<label for="job_qualification"><?php _e( 'Qualification required', 'altiushub' ); ?></label>
			</div>
			<div class="right">
				<input style="width:100%; padding:10px !important;" type="text" id="job_qualification" name="job_qualification" value="<?php echo $job_qualification; ?>" />
			</div>
		</div>
	</div>

	<?php
}

/**
 * Save post data of post type
 *
 * @param int $post_id
 * @return void
 */
function wp_job_save_post_meta( $post_id ) {

	if ( isset( $_POST['job_experience'] ) && $_POST['job_experience'] != '' ) {
		$mydata = $_POST['job_experience'];
		update_post_meta( $post_id, 'job_experience', $mydata );

	}

	if ( isset( $_POST['job_qualification'] ) && $_POST['job_qualification'] != '' ) {
		$mydata = $_POST['job_qualification'];
		update_post_meta( $post_id, 'job_qualification', $mydata );

	}
}
add_action( 'save_post', 'wp_job_save_post_meta' );

function job_editor_content( $content, $post ) {
	if ( 'wp_jobs' == $post->post_type ) {
		$content = __( 'Write job requirement here.', 'wp-job-code' );
	}
	return $content;
}
add_filter( 'default_content', 'job_editor_content', 10, 2 );