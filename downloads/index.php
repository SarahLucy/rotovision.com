<?php
define('WP_USE_THEMES', false);
include_once($_SERVER['DOCUMENT_ROOT']."/wp-load.php");

$root = "http://".$_SERVER['HTTP_HOST']."/downloads/";

$book = isset($_GET['book']) ? $_GET['book'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : '';

if ($page != '' && $book !='')
{
	if (!preg_match("/^[0-9]{1,}$/", $book)) die("Invalid book number");
	if (!preg_match("/^[0-9]{1,}$/", $page)) die("Invalid page number");

	if(isset($_GET['qr']))
	{
		include($_SERVER['DOCUMENT_ROOT']."/qr/qrlib.php");
		QRcode::png($root.$book."/".$page,false,QR_ECLEVEL_H,10);
		exit;
	}

	
	$args = array(
		'post_type' => 'roto_download',
		'roto_download_cat' => $book,
		'name' => $page
	);

	// The Query
	$query = new WP_Query( $args );
	
	// The Loop
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			
			$file = wp_get_attachment_url(rwmb_meta('roto_download_file'));
			
		}
	} else {
		header("HTTP/1.0 404 Not Found");
		exit;
	}
	
	
	$page_title = get_the_title();
}
else
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

?>
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
<meta charset="UTF-8" />
<meta name="robots" content="noindex, nofollow">
<title><?=$page_title?></title>

<link rel="stylesheet" type="text/css" media="all" href="<?=$root?>css/styles.css" />

</head>

<body>
		
	<div id="container">
			
		<div id="content">

			<!-- !MAIN CONTENT -->
			<div id="mainContent">
			
				<div style="width: 640px; margin: 0 auto">
				<h1><?=$page_title?></h1>
				
				<?=the_content()?>
				<p><a class="download" href="<?=$file?>" title="Right-click and 'save link'">Download here</a></p>					
				</div>
				
			</div>  <!-- #mainContent -->

		</div> <!-- #content -->
							
	</div>
	
</body>

</html>