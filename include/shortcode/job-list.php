<?php
function display_job_list() {
	global $post;
	ob_start();
	$args  = array(
		'post_type'   => 'wp_jobs',
		'orderby'     => 'date',
		'order'       => 'DSC',
		'numberposts' => -1,
	);
	$posts = get_posts( $args );

	$terms_name = get_terms(
		array(
			'taxonomy' => 'wp_job_cat',
			'orderby'  => 'meta_value_num',
			'order'    => 'count',
		)
	);

	wp_enqueue_script('jc-custom'); ?>

	<div class="sections_group job-wrapper">
		<div class="section_wrapper">
			<div class="vc_row wpb_row vc_row-fluid">
				<div class="button-group filter-button-group">
					<?php
					foreach ( $terms_name as $my_term ) {
					$slug = $my_term->slug;
					?>
					<button data-filter=".<?php echo $slug; ?>" class="filter_buttons"><?php echo $my_term->name; ?></button>
				<?php } ?>
				</div>
				<div class="js-filter-wrapper" style="margin-top: 40px;">
					<?php foreach ( $posts as $post ) {
						$term_list = wp_get_post_terms( $post->ID, 'wp_job_cat', array( 'fields' => 'slugs' ) ); ?>
						
						<a class="vc_col-md-6 job-item <?php echo implode( ' ', $term_list ); ?>" href="<?php echo get_the_permalink(); ?>">            
							<div class="single-job-wrapper" id="<?php echo $post->ID; ?>">
								<h5 class="title"><?php the_title(); ?></h5>
								<div class="info vc_row wpb_row clearfix">
									<div class="job-type vc_col-md-6">
										<?php
										$job_types = wp_get_post_terms( $post->ID, 'wp_job_type', array( 'fields' => 'all' ) );
										foreach ( $job_types as $job_type ) { ?>
										<span><?php echo $job_type->name; ?></span>
										<?php } ?>
									</div>
									<div class="job-cat vc_col-md-6">
										<?php
										$job_cats = wp_get_post_terms( $post->ID, 'wp_job_cat', array( 'fields' => 'all' ) );
										foreach ( $job_cats as $job_cat ) { ?>
											<span><?php echo $job_cat->name; ?></span>
										<?php } ?>
									</div>
								</div>
							</div>
						</a>
						<?php
					} ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	wp_reset_postdata();
	$output = ob_get_contents();
	ob_get_clean();
	return $output;
}

add_shortcode( 'job-list', 'display_job_list' );
