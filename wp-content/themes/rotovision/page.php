<?php get_header(); ?>

	<!-- !MAIN CONTENT -->
	<div id="mainContent">
	
		<?php if ( have_posts() ) : ?>
	
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<h1><?php the_title(); ?></h1>
				
				<div class="page_content">
					<?php
					$gallery = custom_image_gallery('medium','0','0','',false);
					if($gallery !='')
					{
						?>
						<div class="half_width">
							<?php the_content(); ?>
						</div>
						<div class="slideshow large">
							<?=$gallery?>
						</div>
						<?php
					}
					else
					{
						the_content();
					}
					?>
				</div>
				
				
				

			<?php endwhile; // end of the loop. ?>
		
		<?php endif; ?>

	</div>  <!-- #mainContent -->
	
<?php get_footer(); ?>