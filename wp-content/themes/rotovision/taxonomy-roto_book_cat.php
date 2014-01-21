<?php get_header(); ?>
<?php //get_template_part( 'breadcrumbs' ); ?>

<?php 
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
$args = array(
  'taxonomy'     => 'roto_book_cat',
  'orderby'      => 'term_order'
);
?>
<p id="breadcrumbs">
	<a class="site-home" href="<?= home_url(); ?>">Home</a> | 
	<?php
	$cat_trail = wwp_posttype_breadcrumb( $args,"|");
	echo $cat_trail != '' ? $cat_trail." | " : "";
	?>
	<?=$term->name?>
</p>
<h1><?=$term->name?></h1>
<?php 
query_posts( array_merge( array(
'posts_per_page' => 60), $wp_query->query ) );
$count = $wp_query->post_count;
if ( have_posts() ) : 
	$i=1;
	$n=1;
	?>

	<div class="gallery">

		<div class="row">
		
			<?php 
			while ( have_posts() ) : the_post();
			
				get_template_part( 'content', 'book_cat' );
								
				if($i==6 && $n<$count)
				{
					echo "</div>\n<div class=\"row\">\n";
					$i=1;
				}
				else
				{
					$i++;
				}
				$n++;
			endwhile; 
			?>
			
		</div>
		
	</div>
	
	<?php kriesi_pagination('',4); ?>
	
	<?php 
else : 
	?>

	<div class="entry-content">
		<p>No books available</p>
	</div>

	<?php 
endif; 
?>
	
<?php get_footer(); ?>