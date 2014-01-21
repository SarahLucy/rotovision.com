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

		<h1 class="entry-title"><?php the_title(); ?></h1>

	</div><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<div class="entry-meta">
		<?php
			echo "<p>Posted by: <a href=\"".esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )."\">".get_the_author()."</a></p>";

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ' ) );
			if ( '' != $tag_list )
			{
				echo "<p>Tags: $tag_list</p>";
			}
		?>
	</div><!-- .entry-meta -->
</div><!-- #post-<?php the_ID(); ?> -->