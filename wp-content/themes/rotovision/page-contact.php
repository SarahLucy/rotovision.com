<?php
/*
Template Name: Contact page
*/
?>
<?php get_header(); ?>

<div id="contacts" class="columns">

	<!-- !MAIN CONTENT -->
	<div id="mainContent" class="column colx4">
			
		<h1>Email</h1>
		<?php /*
wp_nav_menu(array('theme_location' => 'contactCats',
					'container'       => '', 
					'menu_class'      => '',
					'before' 	=> '',
					'after'     => '',
					'link_before' => '',
					'link_after' => ''
					));
*/
			
		$cats = get_terms('roto_contact_cat', 'orderby=term_order&hide_empty');    
		foreach ($cats as $cat) :
			
			echo "<div class=\"page_content contact_cat\">\n";
			echo "<a name=\"".$cat->slug."\"></a>\n";
			echo "<h2>".$cat->name."</h2>\n";
			
			$args = array(
				'post_type' => 'roto_contact',
				'orderby'   => 'menu_order',
				'order'     => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'roto_contact_cat',
						'field' => 'slug',
						'terms' => $cat->slug
					)
				),
				'posts_per_page'=> -1
			);
			
			$contacts = new WP_Query($args);
			
			?>
			<ul>
				<?php
				while ($contacts->have_posts()) : $contacts->the_post();
					$position = rwmb_meta('roto_contact_position');
					$email = rwmb_meta('roto_contact_email');
					$areas = rwmb_meta('roto_contact_areas');
					?>
					<li><?php
						echo $position != '' ? $position.": " : "";
						echo $email !='' ? "<a href=\"mailto:$email\">" : "";
						the_title();
						echo $email !='' ? "</a>" : "";
						echo $areas !='' ? " <em>($areas)</em>" : "";
						?></li>
					<?php
				endwhile;
				?>
			</ul>
			<?php
			echo "</div>\n";
		endforeach;	
		wp_reset_query();
		?>
	</div>  <!-- #mainContent -->

	<div id="secContent" class="column colx4 last">
		
		<h2 class="title">Address</h2>
		<?php if ( have_posts() ) : ?>
	
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<div class="page_content">				
										
					<?php the_content(); ?>
				
				</div>
				
			<?php endwhile; // end of the loop. ?>
		
		<?php endif; ?>

					
	</div> <!-- #secContent -->
	
</div>

<?php get_footer(); ?>