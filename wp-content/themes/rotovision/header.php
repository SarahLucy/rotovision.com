<!DOCTYPE html>
<html lang="en">
<!-- 

  Made by
  ______           _________         _       __     __         _ __           
 /_  __/________ _/ __/ __(_)____   | |     / /__  / /_  _____(_) /____  _____
  / / / ___/ __ `/ /_/ /_/ / ___/   | | /| / / _ \/ __ \/ ___/ / __/ _ \/ ___/
 / / / /  / /_/ / __/ __/ / /__     | |/ |/ /  __/ /_/ (__  ) / /_/  __(__  ) 
/_/ /_/   \__,_/_/ /_/ /_/\___/     |__/|__/\___/_.___/____/_/\__/\___/____/  

                                                  www.trafficwebsites.co.uk
 -->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the site name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( 'Page %s', max( $paged, $page ) );;

	?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link type="text/css" rel="stylesheet" href="http://fast.fonts.com/cssapi/cbb2ed0b-1054-427e-b48f-7c1a828aa838.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script src="<?= get_template_directory_uri(); ?>/js/jquery.min.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri(); ?>/js/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri(); ?>/js/swfobject.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function(){
		//$(".FlexoArchives_widget_archives").accordion();
		
		//Equal height for main content and sidebar on blog pages
		$("#blog #mainContent").css("min-height",$("#blog .sidebar").height());

		//Slideshow & Sliders
		$(".slideshow").cycle({
			fx: 		'fade',
			speed: 		1000,
			timeout:	6000,
			delay: 		-1000
		});
		$(".scroller").cycle({
			fx: 'scrollHorz',
			timeout: 0,
			prev: '.scroller_nav .prev',
			next: '.scroller_nav .next'
		});


		//Fancybox
		
		//Add classes, titles, rels to blog img links
		$.fn.getAttr = function() {
		 var arr = $("a.zoom");
		 $.each(arr, function() {
		   var title = $(this).children("img").attr("title");
		   var rel = $(this).parents(".post").attr("id");
		   $(this).attr('title',title);
		   $(this).attr('rel',rel);
		 })
		}	
	
	    $(".entry-content a:has(img)[href$='.jpg']").addClass("zoom").getAttr();
	    $(".entry-content a:has(img)[href$='.jpeg']").addClass("zoom").getAttr();
	    $(".entry-content a:has(img)[href$='.gif']").addClass("zoom").getAttr();
	    $(".entry-content a:has(img)[href$='.png']").addClass("zoom").getAttr();
	    $(".entry-content a:has(img)[href$='.bmp']").addClass("zoom").getAttr();

	    $(".entry-content a:has(img)[href$='.JPG']").addClass("zoom").getAttr();
	    $(".entry-content a:has(img)[href$='.JPEG']").addClass("zoom").getAttr();
	    $(".entry-content a:has(img)[href$='.GIF']").addClass("zoom").getAttr();
	    $(".entry-content a:has(img)[href$='.PNG']").addClass("zoom").getAttr();
	    $(".entry-content a:has(img)[href$='.BMP']").addClass("zoom").getAttr();
	    
	    var attachment = $(".entry-content a:has(img)[rel^='attachment']");
	    attachment.each(function(){
		    
			var att_img = $(this).find("img").attr("src");
		    /*
		    console.log(att_img);
		    var ext = att_img.substr( (att_img.lastIndexOf('.') +1) );
		    var att_fullimg = att_img.substring(0, att_img.lastIndexOf("-"));
		    $(this).removeAttr("rel").addClass("zoom").attr("href",att_fullimg+'.'+ext);
		    */
		    $(this).removeAttr("rel").addClass("zoom").attr("href",att_img).getAttr();
			
		});
	    
		$(".zoom").fancybox({
			padding: 5 
		});

		//Animated anchors
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$('[name="'+this.hash.substring(1)+'"]').offset().top}, 500);
		});

		//Small tweak for blog images
		$("#blog p img.size-thumbnail:last").css("margin-right", 0);

	})
</script>
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	
	wp_head();
?>
</head>

<body <?php body_class(); ?>>

<a name="top"></a>

<div id="wrap">
		
	<div id="container">
	
		<div id="header">
			
			<div id="site_logo">
				<a href="<?= home_url(); ?>"><?php bloginfo( 'name' );?></a>
			</div>
			
			<?php wp_nav_menu( array('theme_location' 	=> 'mainNav',
									 'container_class' 	=> 'mainNavHolder',
									 'menu_class'     	=> 'nav mainNav'
							) ); ?>
											
		</div>
		
		<div id="content">