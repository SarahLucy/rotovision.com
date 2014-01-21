<?php
/*
Template Name: Newsletter signup
*/
?>
<?php get_header(); ?>

<!-- <link href="https://app.e2ma.net/css/signup.lrg.css" rel="stylesheet" type="text/css"> -->

<div id="newsletter" class="columns">

	<!-- !MAIN CONTENT -->
	<div id="mainContent" class="column colx4">
		<?php if ( have_posts() ) : ?>
	
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<h1><?php the_title(); ?></h1>
				
				<div class="page_content">				
										
					<?php the_content(); ?>
				
				</div><!-- .page_content -->
				
			<?php endwhile; // end of the loop. ?>
		
		<?php endif; ?>

					
	</div> <!-- #mainContent -->
	
	<div id="secContent" class="column colx4 last">
	
		<!-- !Form embed code -->
		<script type="text/javascript" src="https://app.e2ma.net/app2/audience/tts_signup/1723922/19bdcfcac36f518cfedf1a364db02793/17856/?v=a"></script><div id="load_check" class="signup_form_message" >This form needs Javascript to display, which your browser doesn't support. <a href="https://app.e2ma.net/app2/audience/signup/1723922/17856/?v=a"> Sign up here</a> instead </div><script type="text/javascript">signupFormObj.drawForm();</script>
		<script type="text/javascript">
			$(".e2ma_signup_form_group_label").text("Subjects of interest:");
		</script>

	</div> <!-- #secContent -->

</div>

<?php get_footer(); ?>