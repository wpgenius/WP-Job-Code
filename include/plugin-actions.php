<?php

function apply_templates( $template ) {
	global $post;
	$post_type = get_post_type( $post );
	if ( $post_type == 'wp_jobs' ) {
		if ( is_single() ) {
			if ( locate_template( array( 'single-wp_jobs.php' ) ) ) {
				$template = locate_template( 'single-wp_jobs.php', true );
			} else {
				$template = WP_JOB_DIR_PATH . 'templates/single-wp_jobs.php';
			}
		}
	}

	return $template;
}

add_filter( 'template_include', 'apply_templates' );
