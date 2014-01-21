<?php
/*
Template name: Back List Book categories
*/
?>
<?php get_header(); ?>

<?php //get_template_part( 'breadcrumbs' ); ?>

<p id="breadcrumbs">
	<a class="site-home" href="<?= home_url(); ?>">Home</a> | 
	<!-- <a class="site-home" href="<?= home_url(); ?>/rights">Rights</a> |  -->
	Back list</p>


<!-- !MAIN CONTENT -->
<div id="mainContent" class="categories has_sidebar">
	
	<h1><?php the_title()?></h1>
				
	<?php
	$cats = get_terms('roto_book_cat', 'parent=21&orderby=term_order&hide_empty'); //21 = Back list
	if(count($cats)>0)
	{
		?>
		<ul>
			<?php
	
			foreach ($cats as $cat) :
				
				?>
				<li class="book_cat">
					<a class="cat_image" href="<?=get_term_link($cat->slug, 'roto_book_cat')?>">
						<?=ciii_term_images('roto_book_cat',array('echo' => false,'link_images' => false,'size' => 'thumb','term_ids'=>$cat->term_id));?>
						<div class="cat_summary">
							<h2><?=$cat->name?></h2>
							<p><?=$cat->description?></p>
						</div>
					</a>
				</li>
				<?php
				
			endforeach;	
			?>
		</ul>
		<?php
	}
	?>

</div> <!-- #mainContent -->

<!-- !SIDEBAR -->
<div class="sidebar">
	
	<h2>SEARCH</h2>
	
	<form method="get" id="book_search" action="<?php bloginfo('url'); ?>">
		<input type="hidden" name="scope" value="books">
		<input type="hidden" name="cat" value="back-list">
		<fieldset>
			<input type="text" class="textfield" name="s" id="s" value=""/>
			<ul class="check_set">
				<li><input type="radio" name="searchby" value="title" id="radio_title"/> <label for="radio_title">TITLE</label></li>
				<li><input type="radio" name="searchby" value="subject" id="radio_subject"/> <label for="radio_subject">SUBJECT</label></li>
				<li><input type="radio" name="searchby" value="keyword" id="radio_keyword"/> <label for="radio_keyword">KEYWORD</label></li>
				<li><input type="radio" name="searchby" value="author" id="radio_author"/> <label for="radio_author">AUTHOR</label></li>
				<li><input type="radio" name="searchby" value="publisher" id="radio_publisher"/> <label for="radio_publisher">PUBLISHER</label></li>
				<li><input type="radio" name="searchby" value="isbn" id="radio_isbn"/> <label for="radio_isbn">ISBN</label></li>
			</ul>
		</fieldset>
		<input type="submit" class="button submit button_search" name="submit" value="Go"/>
	</form>

</div> <!-- .sidebar -->

<?php get_footer(); ?>