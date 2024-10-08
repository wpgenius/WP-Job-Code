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


/**
 * Filter breadcrumbs on Salary Data pages.
 *
 * @param array $link The link array.
 * @param array $breadcrumb The breadcrumb item array.
 *
 * @return str  $link The link output.
 */
function yoast_seo_breadcrumb_append_link( $links ) {

	if ( is_singular( 'wp_jobs' ) ) {

		$page = get_page_by_path('careers');

		$breadcrumb[] = array(
            'url' => get_permalink( $page ),
            'text' => get_the_title($page),
        );

        array_splice( $links, 1, -2, $breadcrumb );

	}

	return $links;
}
add_filter( 'wpseo_breadcrumb_links', 'yoast_seo_breadcrumb_append_link' );