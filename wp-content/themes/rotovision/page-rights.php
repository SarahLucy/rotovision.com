<?php
/*
Template Name: Rights page
*/
?>
<?php get_header(); ?>

<div id="rights">

	<!-- !MAIN CONTENT -->
	<div id="mainContent">
	
		<?php if ( have_posts() ) : ?>
	
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<h1><?php the_title(); ?></h1>
				
				
					<div class="post_content">
						
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:' ) . '</span>', 'after' => '</div>' ) ); ?>
						
					</div><!-- .entry-content -->

					<?php
					$gallery = custom_image_gallery('medium','0','0',2); //2 = home page ID
					if($gallery !='')
					{
						?>
						<div class="slideshow">
							<?=$gallery?>
						</div>
						<?php
						
					}
					?>

				
				</div><!-- #post-<?php the_ID(); ?> -->
				
			<?php endwhile; // end of the loop. ?>
		
		<?php endif; ?>

	</div>  <!-- #mainContent -->

	<div id="secContent">
	
		<?php wp_nav_menu(array('theme_location' => 'rightsNav',
					'container'       => false, 
					'menu_class'      => 'columns rightsNav',
					'before' 	=> '<img class="arrow-down" src="'.get_template_directory_uri().'/images/arrow-down-red.png" alt="arrow-down-red" width="22" height="27"/>',
					'after'     => '',
					'link_before' => '',
					'link_after' => '',
					'walker' => new rights_walker()
					));
					?>
					
	</div> <!-- #secContent -->
	
</div>

<?php get_footer(); ?>