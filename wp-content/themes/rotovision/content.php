<?php 
//Get an array of category ids for this post
$post_id = get_the_ID();
$post_categories = wp_get_post_categories( $post_id );
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-header">
		<?php
		//Display category image
		ciii_term_images( 'category',array('size' => 'original'));

		if ( 'post' == get_post_type() )
		{
			?>
			<p class="post-date"><?php the_date(); ?></p>
			<?php 
		}
		?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php
		if ( is_sticky() )
		{
			?>
			<h3 class="entry-format"><?php _e( 'Featured' ); ?></h3>
			<?php 
		}
		?>

	</div><!-- .entry-header -->

	<?php 
	if ( is_search() ) 
	{ // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php 
	}
	else 
	{
		?>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php 
	} ?>

	<div class="entry-meta">

		<?php
		if ( comments_open() )
		{
			?>			
			<p class="comments-link"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
			<?php
		}
		
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ' ) );
		if ( $tags_list )
		{
			printf( __( '<p class="%1$s">Tags: %2$s</p>' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); 
		}

		?>
		
	</div><!-- #entry-meta -->
</div><!-- #post-<?php the_ID(); ?> -->