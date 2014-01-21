<?php get_header(); ?>

<div id="blog">

	<?php get_template_part( 'socnet' ); ?>
	
	<hr class="content_top"/>
	
	<!-- !MAIN CONTENT -->
	<div id="mainContent" class="has_sidebar">
	
		<?php if ( have_posts() ) : ?>
	
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>
		
		<?php endif; ?>

	</div>  <!-- #mainContent -->
	
	<!-- !SIDEBAR -->
	<div class="sidebar">
		<?php dynamic_sidebar('blog_sidebar'); ?>
	</div> <!-- .sidebar -->

</div>

<?php get_footer(); ?>