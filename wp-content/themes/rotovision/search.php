<?php
/**
 * The template for displaying search results.
 *
 * @package WordPress
 * @subpackage Rotovision
 */
?>
<?php get_header(); ?>
<?php
global $wp_query;
if ( isset( $_GET['scope'] ) && $_GET['scope']=='books' )
{
	//Get selected option
	$searchby = isset($_GET['searchby']) && $_GET['searchby'] != '' ? $_GET['searchby'] : 'keyword';
	$cat = isset($_GET['cat']) && $_GET['cat'] != '' ? $_GET['cat'] : 'front-list';
	$searchterm = isset($_GET['s']) ? mysql_real_escape_string($_GET['s']) : '';

	$args = array(
	 'post_type'=> 'roto_book'/*
,
	 'tax_query' => array(
					array(
						'taxonomy' => 'roto_book_cat',
						'field' => 'slug',
						'terms' => $cat
					)
				)
*/
	);
	switch($searchby)
	{
		case "title":
			$args['post_title_like'] = $searchterm;
		break;
		
		case "subject":
			$args['tax_query']['relation'] = 'AND';
			$args['tax_query'][] = array(
										'taxonomy' => 'roto_book_subject_tag',
										'field' => 'slug',
										'terms' => $searchterm
									);
		break;
		
		
		case "author":
			$args['meta_query']= array(
				array(
					'key' => 'roto_author_name',
					'value' => $searchterm,
					'compare' => 'LIKE'
				)
			);
		break;
		
		case "publisher":
			$args['tax_query']['relation'] = 'AND';
			$args['tax_query'][] = array(
										'taxonomy' => 'roto_book_publisher_tag',
										'field' => 'slug',
										'terms' => $searchterm
									);
		break;
		
		case "isbn":
			$args['meta_query']= array(
				array(
					'key' => 'roto_book_isbn',
					'value' => $searchterm,
					'compare' => 'LIKE'
				)
			);
		break;
		case "keyword":
		default:
			$args['tax_query']['relation'] = 'AND';
			$args['tax_query'][] = array(
										'taxonomy' => 'roto_book_tag',
										'field' => 'slug',
										'terms' => $searchterm
									);
		break;
	}
	$books = new WP_Query( $args );
	?>
	<h1>Search results for <q><?=$searchterm?></q></h1>
	
	<?php
	if ( $books->have_posts() )
    {
	    $i=1;
	    ?>
	    
		<div class="gallery">
	
			<div class="row">
			
				<?php 
				while ($books->have_posts()) : $books->the_post();
				
					get_template_part( 'content', 'book_cat' );
									
					if($i==6)
					{
						echo "</div>\n<div class=\"row\">\n";
						$i=1;
					}
					else
					{
						$i++;
					}
				endwhile; 
				?>
				<?php if( function_exists( 'wp_paginate' ) ) { wp_paginate();	} ?>
			</div>
			
		</div>
 
 
		<?php
	}
	else
	{
		?>
		<p>Your Search returned no results. Please try again.</p>
		<?php
	}
}			
else
{
	?>
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
	<?php
}
?>
<?php get_footer();?>

