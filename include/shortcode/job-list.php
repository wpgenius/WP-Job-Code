<?php 
function display_job_list(){
	global $post;
	ob_start();
	$args = array('post_type'=>'wp_jobs',
				  'orderby'  => 'date',
				  'order'    => 'DSC',
				  'numberposts'=> -1,
				);
	$posts = get_posts($args);

	echo '<div class="sections_group job-wrapper">';
		echo '<div class="section_wrapper">';
			echo '<div class="vc_row wpb_row vc_row-fluid">';
			foreach($posts as $post){
				?>
				<a class="vc_col-md-6" href="<?php echo get_the_permalink(); ?>">            
					<div class="single-job-wrapper" id="<?php echo $post->ID; ?>">
			          	<h5 class="title"><?php the_title(); ?></h5>
			          	<div class="info vc_row wpb_row clearfix">
			                <div class="job-type vc_col-md-6">
			                	<?php
			                	$job_types =  wp_get_post_terms( $post->ID, 'wp_job_type', array( 'fields' => 'all' ) );
								foreach( $job_types as $job_type ) {  ?>
			                		<span><?php echo $job_type->name; ?></span>
			                	<?php } ?>
			                </div>
			                <div class="job-cat vc_col-md-6">
			                	<?php
				                $job_cats = wp_get_post_terms( $post->ID, 'wp_job_cat', array( 'fields' => 'all' ) ); 
			                	foreach( $job_cats as $job_cat ) { ?>
			                		<span><?php echo $job_cat->name; ?></span>
			                	<?php } ?>
			                </div>
			          	</div>
		            </div>
		         </a>
				<?php
			}
			echo '</div>';
		echo '</div>';
	echo '</div>';
	wp_reset_postdata();
	$output = ob_get_contents();
	ob_get_clean();
	return $output;
}

add_shortcode('job-list','display_job_list');