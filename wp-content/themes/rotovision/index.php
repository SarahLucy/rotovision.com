<?php get_header(); ?>

<div id="blog">

	<?php get_template_part( 'socnet' ); ?>
	
	<hr class="content_top"/>
	
	<!-- !MAIN CONTENT -->
	<div id="mainContent" class="has_sidebar">
	
		<?php if ( have_posts() ) : ?>
	
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
	
				<?php get_template_part( 'content', get_post_format() ); ?>
	
			<?php endwhile; ?>
	
			
			<?php kriesi_pagination('',4); ?>
			
		<?php else : ?>
	
			<h2 class="entry-title"><?php _e( 'Nothing Found' ); ?></h2>
				
			<div class="entry-content">
				<p>Apologies, but no articles were found here.</p>
			</div><!-- .entry-content -->
	
		<?php endif; ?>
		
	</div> <!-- #mainContent -->
	
	<!-- !SIDEBAR -->
	<div class="sidebar">  
		<?php dynamic_sidebar('blog_sidebar'); ?>
	</div> <!-- .sidebar -->

</div>

<?php get_footer(); ?>