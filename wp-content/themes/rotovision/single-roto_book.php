<?php get_header(); ?>

<!-- !BREADCRUMBS -->
<?php //get_template_part( 'breadcrumbs' ); ?>


<?php if ( have_posts() ) : ?>

	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<p id="breadcrumbs">
			<a class="site-home" href="<?= home_url(); ?>">Home</a> | 

<?php
			//Sort out some URLS
			
			$find = array("books/back-list","books/front-list");
			$replace = array("back-list","books");

			$tax = 	'roto_book_cat';
		    $cats = get_the_terms($post->ID,$tax);
		    foreach($cats as $cat)
		    {
		    	$cat_link = str_replace($find,$replace,get_term_link( $cat ));
		    }
		    $parent = get_term_by('id', $cat->parent, $tax);
		    $parent_link = str_replace($find,$replace,get_term_link( $parent ));
			     
			$cat_trail =  !empty($parent) ? "<a href=\"".$parent_link."\">".$parent->name."</a> | " : "";
			$cat_trail .=  !empty($cat) ? "<a href=\"".$cat_link."\">".$cat->name."</a>" : ""; 
			echo $cat_trail != '' ? $cat_trail." | " : "";

			?>

			<?php the_title(); ?>
		</p>

			
		<?php get_template_part( 'content', 'book' ); ?>
		
	<?php endwhile; // end of the loop. ?>

<?php endif; ?>

<?php get_footer(); ?>