<?php 
if(rwmb_meta('roto_book_cover'))
{
	$covers = rwmb_meta('roto_book_cover',array('type'=>'thickbox_image','size'=>'thumbnail'));
	foreach($covers as $cover)
	{				
		$cover_img = '<img src="'.$cover['url'].'" alt="'.$cover['alt'].'" />';
	}
}
else
{
	$cover_img = '<img src="'.get_template_directory_uri().'/images/book-placeholder.png" alt="'.get_the_title().'" />';
}
global $i;
?>

<a<?=$i==6?' class="last"':''?> href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>"><?=$cover_img?></a>