<?php
$root = "http://".$_SERVER['HTTP_HOST']."/video/";
$book = isset($_GET['book']) ? $_GET['book'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : '';

if ($page != '' && $book !='')
{
	if (!preg_match("/^[0-9]{1,}$/", $book)) die("Invalid book number");
	if (!preg_match("/^[0-9]{1,}$/", $page)) die("Invalid page number");
	$page_title = $book." / ".$page;
	include("includes/meta.php");
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
						
				<video width="640" height="360" controls style="margin-bottom: 10px">
					<source src="<?=$root?>MP4/<?=$book?>/<?=$page?>.mp4" type="video/mp4" /><!-- Safari / iOS video    -->
					<source src="<?=$root?>WEBM/<?=$book?>/<?=$page?>.webm" type="video/webm" /><!-- Firefox / Opera / Chrome10 -->
					<source src="<?=$root?>OGG//<?=$book?>/<?=$page?>.ogv" type="video/ogg" /><!-- Firefox / Opera / Chrome10 -->
					<object width="640" height="360" type="application/x-shockwave-flash" data="<?=$root?>FLASH/flowplayer-3.2.15.swf" style="background: black; margin-bottom: 10px">
						<param name="movie" value="<?=$root?>FLASH/flowplayer-3.2.15.swf" />
						<param name="wmode" value="transparent" />
						<param name="allowfullscreen" value="true" />
						<param name="flashvars" value='config={	"clip": {
																	"url": "../MP4/<?=$book?>/<?=$page?>.mp4",
																	"autoPlay":false,
																	"autoBuffering":false,
																	"scaling":"fit"
																	}
																 }' />
					</object>
				</video>
				<p><a class="download" href="<?=$root?>MP4/<?=$book?>/<?=$page?>.mp4" title="Right-click and 'save link'">If the above video does not play, you can download it here</a></p>					
				</div>
				
			</div>  <!-- #mainContent -->

		</div> <!-- #content -->
							
	</div>
	
</body>

</html>