<?php
$roto_about_author 		= rwmb_meta('roto_about_author');
$roto_preview 			= rwmb_meta('roto_preview');
$roto_book_isbn 		= rwmb_meta('roto_book_isbn');
$roto_book_page_count	= rwmb_meta('roto_book_page_count');
$roto_book_word_count	= rwmb_meta('roto_book_word_count');
$roto_book_img_count	= rwmb_meta('roto_book_img_count');
$roto_book_dimensions	= rwmb_meta('roto_book_dimensions');
$roto_book_rights_sold	= rwmb_meta('roto_book_rights_sold');
$roto_book_translation	= rwmb_meta('roto_book_translation');
$reviews = new WP_Query(array('connected_type' => 'reviews_to_books','connected_items' => get_queried_object(),'nopaging' => true));
$cover_gallery = rwmb_meta('roto_cover_gallery',array('type'=>'plupload_image','size'=>'thumbnail'));
$related = new WP_Query(array('connected_type' => 'related_books','connected_items' => get_queried_object(),'nopaging' => true));

?>

<!-- !ANCHOR LINKS -->
<p id="anchors">
	<?php
	$anchors = array();
	if($roto_about_author !='')
	{
		$anchors[] = '<a href="#author" class="scroll">ABOUT THE AUTHOR</a>';
	}
	if($roto_preview !='')
	{
		$anchors[] = '<a href="#preview-spreads" class="scroll">PREVIEW SPREADS</a>';
	}
	if(	$roto_book_isbn 		.
		$roto_book_page_count	.
		$roto_book_word_count	.
		$roto_book_img_count	.
		$roto_book_dimensions	.
		$roto_book_rights_sold	.
		$roto_book_translation !='')
	{
		$anchors[] = '<a href="#book-specs" class="scroll">BOOK SPECS</a>';
	}
	if($reviews->have_posts())
	{
		$anchors[] = '<a href="#reviews" class="scroll">REVIEWS</a>';
	}
	if(count($cover_gallery)>0)
	{
		$anchors[] = '<a href="#cover-gallery" class="scroll">COVER GALLERY</a>';
	}
	if($related->have_posts())
	{
		$anchors[] = '<a href="#related" class="scroll">YOU MIGHT ALSO LIKE</a>';
	}
	if(count($anchors)>0)
	{
		echo implode(" / ", $anchors);
	}
	?>
</p>

<!-- !MAIN CONTENT -->
<div id="mainContent">
	
	<div id="book_single">
	
		<h1>
			<?php the_title(); ?>
			<?php 
			if(rwmb_meta('roto_author_name'))
			{
				?>	
			
				<a class="scroll" href="#author">by <?= rwmb_meta('roto_author_name'); ?></a>
				
				<?php
			}
			?>
		</h1>
		
		<div id="book_details">
			
			<div class="sidebar">
				
				<?php 
				if(rwmb_meta('roto_book_cover'))
				{
					?>
					<!-- !MAIN IMAGE -->
					<div id="main_image">
						<?php
						$covers = rwmb_meta('roto_book_cover',array('type'=>'thickbox_image','size'=>'large'));
						foreach($covers as $cover)
						{				
							?>
							<img src="<?=$cover['url']?>" alt="<?=$cover['alt']?>" />
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
				
				<!-- !PURCHASE LINKS -->
				<ul class="purchase">
					<?php 
					if(rwmb_meta('roto_book_amazon_uk'))
					{
						?>	
						<li><a href="<?=rwmb_meta('roto_book_amazon_uk')?>" target="_blank"><span class="icon"></span>Buy from UK amazon</a></li>			
						<?php
					}
					if(rwmb_meta('roto_book_amazon_usa'))
					{
						?>	
						<li><a href="<?=rwmb_meta('roto_book_amazon_usa')?>" target="_blank"><span class="icon"></span>Buy from US amazon</a></li>			
						<?php
					}
					?>
				</ul>
				
				<?php 
				if( $roto_book_isbn 		.
					$roto_book_page_count	.
					$roto_book_word_count	.
					$roto_book_img_count	.
					$roto_book_dimensions	.
					$roto_book_rights_sold	.
					$roto_book_translation !='')
				{
					?>
					
					<!-- !BOOK SPECS -->
					<div id="book_specs">
					
						<a name="book_specs"></a>
						
						<h2 class="sectionHeader"><span>Book specs</span></h2>
						
						<ul>
							<?php
							echo $roto_book_isbn 		!= '' ? "<li>ISBN: $roto_book_isbn</li>\n" : '';
							echo $roto_book_page_count	!= '' ? "<li>$roto_book_page_count pages</li>\n" : '';
							echo $roto_book_word_count	!= '' ? "<li>$roto_book_word_count words</li>\n" : '';
							echo $roto_book_img_count	!= '' ? "<li>$roto_book_img_count images</li>\n" : '';
							echo $roto_book_dimensions	!= '' ? "<li>$roto_book_dimensions</li>\n" : '';
							echo $roto_book_rights_sold	!= '' ? "<li>Rights sold: $roto_book_rights_sold</li>\n" : '';
							echo $roto_book_translation	!= '' ? "<li>Available for translation: $roto_book_translation</li>\n" : '';
							?>
						</ul>
						
					</div>
					
					<?php
				}
				?>
				
				<!-- !BUY RIGHTS -->
				<a name="buy_rights" class="button_book_sidebar" href="<?= home_url(); ?>/contact-us/#rights">Buy rights</a>
									
				<?php
				// Find reviews

				if ( $reviews->have_posts() ) :
					?>
					<!-- !REVIEWS -->
					<div id="book_reviews">
					
						<a name="reviews"></a>
					
						<h2 class="sectionHeader"><span>Book reviews</span></h2>
						
						<?php while ( $reviews->have_posts() ) : $reviews->the_post(); ?>
							
							<?php
							$roto_reviewer = rwmb_meta('roto_reviewer');
							$roto_review_url = rwmb_meta('roto_review_url');
							?>
							
							<blockquote<?= $roto_review_url !='' ? ' cite="'.$roto_review_url.'"' : ''?>>
								<p><?= $roto_review_url !='' ? '<a href="'.$roto_review_url.'" target="_blank">' : ''?><q><?= get_the_content() ?></q><?= $roto_review_url !='' ? '</a>' : ''?> <?= $roto_reviewer !='' ? '<cite>'.$roto_reviewer.'</cite>' : ''?></p>
							</blockquote>
		
						<?php endwhile; ?>
					
					</div>
							
					<?php 
					// Prevent weirdness
					wp_reset_postdata();
				
				endif;
				?>
						
			</div> <!-- .sidebar -->
			
			<div id="book_info">
			
				<?php the_content(); ?>
											
				
				
				<?php 
				if($roto_about_author !='')
				{
					?>	
					<!-- !AUTHOR -->
					<a name="author"></a>
		
					<h3>About the Author</h3>
					
					<?php echo rwmb_meta('roto_about_author'); ?>
					
					<?php
				}
				?>
			
				<?php 
				if($roto_preview !='')
				{
					?>	
					<!-- !PREVIEW SPREADS -->
					
					<a name="preview-spreads"></a>
					
					<h2 class="sectionHeader"><span>Preview spreads</span></h2>
					
					<div class="issuu">
					</div>
					
					<?php $issuu_link = rwmb_meta('roto_issuu_link') !='' ? rwmb_meta('roto_issuu_link') : "http://issuu.com/rotovision"; ?>
					
					<script type="text/javascript">
						if (swfobject.hasFlashPlayerVersion("9.0.0")) 
						{
						  $(".issuu").html('<?php echo rwmb_meta('roto_preview'); ?>');
						}
						else 
						{
						  $(".issuu").html('<div class="noflash"><p>your browser does<br/>not support Flash</p><p><a class="button_issuu" href="<?=$issuu_link; ?>" target="_blank">click here to view at issuu.com</a></p></div>');
						}
					</script>
					
					
					<?php
				}
				?>
			
			</div> <!-- #book_info -->
			
			<div class="clear"></div>
			
		</div> <!-- #book_details -->
		
		<?php
		$cg_count = count($cover_gallery);
		
		if($cg_count>0)
		{
			?>
			<!-- !COVER GALLERY -->
			
			<a name="cover-gallery"></a>
			
			<h2 class="sectionHeader"><span>Cover gallery</span></h2>
			
			<div class="cover_gallery">
				<div class="row">
				<?php
				$i=1;
				$n=1;
				foreach($cover_gallery as $gal)
				{				
					$linked = $gal['description'] !='' ? true : false;
					$class = $i==4 ? 'last' : '';
					?>
					
					<a href="<?= $linked == true ? $gal['description'].'" class="'.$class : $gal['full_url'].'" class="zoom '.$class.'" rel="gallery' ?>" target="_blank">
						<img src="<?=$gal['url']?>" alt="<?=$gal['alt']?>" />
						<br/>
						<span class="cg_title"><?=$gal['title']?></span>
					</a>
					
					<?php 
					if($i==4 && $n<$cg_count)
					{
						echo "</div>\n<div class=\"row\">\n";
						$i=1;
					}
					else
					{
						$i++;
					}
					$n++;
				}
				?>
				</div>
			</div>
		
<!--
			<div class="cover_gallery links">
				
				<div class="row">
					
				<?php
				$i=1;
				foreach($cover_gallery as $gal)
				{				
					$linked = $gal['description'] !='' ? true : false;
					$class = $i==4 ? 'last' : '';
					?>
					
					<a href="<?= $linked == true ? $gal['description'].'" class="'.$class : $gal['full_url'].'" class="zoom '.$class.'" rel="gallery' ?>" target=\"_blank\">
						<?=$gal['title']?>
					</a>
					
					<?php 
					if($i==4)
					{
						echo "</div>\n<div class=\"row\">\n";
						$i=1;
					}
					else
					{
						$i++;
					}
				}
				?>		
				
				</div>
				
			</div>
-->
			
			<?php
		}
		?>
		
		<?php
		// Find related books
		if ( $related->have_posts() ) :
			?>
			<!-- !RELATED CONTENT -->
			
			<a name="related"></a>
			
			<h2 class="sectionHeader"><span>You might also like</span></h2>
			
			<div class="cover_gallery related">
			
				<div class="row">
					<?php 
					$i=1;
					$n=1;
					$count = $related->post_count;
					while ( $related->have_posts() ) : $related->the_post(); ?>
						<?php 
						if(rwmb_meta('roto_book_cover'))
						{
							$covers = rwmb_meta('roto_book_cover',array('type'=>'thickbox_image','size'=>'thumbnail'));
							foreach($covers as $cover)
							{				
								$display = '<img src="'.$cover['url'].'" alt="'.$cover['alt'].'" />';
							}
							?>
							<?php
						}
						else
						{
							$display = the_title_attribute('echo=0');
						}
						?>
						
						<a<?=$i==4?' class="last"':''?> href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?=$display?></a>
					
						<?php 
						if($i==4 && $n < $count)
						{
							echo "</div>\n<div class=\"row\">\n";
							$i=1;
						}
						else
						{
							$i++;
						}
						$n++;
					endwhile; ?>
				</div>			
			</div>
					
			<?php 
			// Prevent weirdness
			wp_reset_postdata();
		
		endif;
		?>
		
		
		<a href="#top" class="top_link scroll">Back to top</a>

	</div> <!-- #book_single -->

</div>  <!-- #mainContent -->		