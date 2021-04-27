<?php 
get_header(); 
global $post;
?>

<div id="Content">
	<div class="content_wrapper clearfix">

		<div class="sections_group">
			<?php

				if (have_posts()) {

					while (have_posts()) {

						the_post();

						$mfn_builder = new Mfn_Builder_Front(get_the_ID());
						$mfn_builder->show();

					}

				} else {

					// template: default

					while (have_posts()) {
						echo "No job found";
					}
				}

			?>
		</div>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer();