<?php
/*
Template Name: Home page
*/
?>
<?php get_header(); ?>

<?php 

while ( have_posts() ) : the_post(); ?>

	<!-- !MAIN CONTENT -->
	
	<div id="mainContent">
				
		<div class="post_content">

			<h1><?php the_title(); ?></h1>
		
			<?php the_content(); ?>
			
		</div>
		
		<?php
		$gallery = custom_image_gallery('medium','0','0');
		if($gallery !='')
		{
			?>
			<div class="slideshow">
				<?=$gallery?>
			</div>
			<?php
			
		}
		?>
	</div> <!-- #mainContent -->

<?php 
endwhile; ?>
								

<a class="ribbon leftside bloglink" href="<?=site_url();?>/blog">Check out our blog</a>

<div id="secContent">

	<?php
	$args = array(
    'post_type' => 'roto_book',
    'post_status' => 'publish',
    'posts_per_page' => 18,
    'tax_query' => array(
					array(
						'taxonomy' => 'roto_book_cat',
						'field' => 'slug',
						'terms' => 'front-list'
					)
				)
    );
    $books = new WP_Query( $args );
    if ( $books->have_posts() )
    {
    	//print_r($books);
    	$count = $books->post_count;
    	?>
    	<h2 class="sectionHeader"><span>RECENT RELEASES</span></h2>
	
		<div class="scroller gallery">
		
			<div class="row slide">	
				<?php
				$i=1;
				$num = 1;
		    	while ($books->have_posts()) : $books->the_post();		    		
					
		    		if(rwmb_meta('roto_book_cover'))
					{
						$covers = rwmb_meta('roto_book_cover',array('type'=>'thickbox_image','size'=>'thumbnail'));
						foreach($covers as $cover)
						{			
							$imgattr = imageResize($cover['width'], $cover['height'], 100, 'width');
							$cover_img = '<img src="'.$cover['url'].'" alt="'.$cover['alt'].'" '.$imgattr.'/>';
						}
					}
					else
					{
						
						$cover_img = '<img src="'.get_template_directory_uri().'/images/book-placeholder.png" alt="'.get_the_title().'" />';
					}

		    		?>
			    	
			    	<a<?=$i==6?' class="last"':''?> href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			    		<?=$cover_img?>
			    	</a>
			    	
			    	<?php
			    	
			    	if($i==6 && $num < $count)
			    	{
				    	echo "</div>\n<div class=\"row slide\">\n";
				    	$i=1;
			    	}
			    	else
			    	{
			    		$i++;
			    	}
			    	$num++;
			    endwhile;
			    
			    ?>
			</div> <!-- .row.slide -->
			
		</div> <!-- .scroller.gallery -->
		<div class="scroller_nav">
		
			<a href="#" class="prev">Previous</a>
			<a href="#" class="next">Next</a>
		
		</div>
		<?php
    }
    wp_reset_query();
	?>
		

</div> <!-- #secContent -->


<?php get_footer(); ?>