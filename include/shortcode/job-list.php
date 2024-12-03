<?php
function display_job_list()
{
	global $post;
	ob_start();
	$args  = array(
		'post_type'   => 'wp_jobs',
		'orderby'     => 'date',
		'order'       => 'DSC',
		'numberposts' => -1,
	);
	$posts = get_posts($args);

	$terms_name = get_terms(
		array(
			'taxonomy' => 'wp_job_cat',
			'orderby'  => 'term_id',
			'order'    => 'asc',
		)
	);

	wp_enqueue_script('jc-custom'); ?>

	<div class="sections_group job-wrapper">
		<div class="section_wrapper">
			<div class="vc_row wpb_row vc_row-fluid">
				<div class="button-group filter-button-group">
					<?php
					foreach ($terms_name as $my_term) {
						$slug = $my_term->slug;
					?>
						<button data-filter=".<?php echo $slug; ?>" class="filter_buttons"><?php echo $my_term->name; ?></button>
					<?php } ?>
				</div>
				<div class="js-filter-wrapper" style="margin-top: 40px;">
					<?php
					foreach ($posts as $post) {
						$term_list = wp_get_post_terms($post->ID, 'wp_job_cat', array('fields' => 'slugs'));
					?>

						<div class="job-item <?php echo implode(' ', $term_list); ?>" href="<?php echo get_the_permalink(); ?>">
							<div class="single-job-wrapper" id="<?php echo $post->ID; ?>">
								<div class="title">
									<h5><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h5>
								</div>
								<div class="job-type">
									<?php
									$job_types = wp_get_post_terms($post->ID, 'wp_job_type', array('fields' => 'all'));
									foreach ($job_types as $job_type) { ?>
										<span><?php echo $job_type->name; ?></span>
									<?php } ?>
								</div>
								<div class="location">
									<span><?php echo get_post_meta($post->ID, 'job_location', true); ?></span>
								</div>
								<div class="job-link">
									<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo WP_JOB_DIR_URL . 'assets/images/job-code-icon.png'; ?>" alt=""></a>
								</div>
							</div>
						</div>
					<?php
					}
					?>
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

add_shortcode('job-list', 'display_job_list');
