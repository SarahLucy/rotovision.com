<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php foreach( $terms AS & $term ) { ?>
	<?php 
	if ( $link_images ) : ?><a href="<?php 
	echo esc_attr( get_term_link( $term[ 'id' ], $taxonomy ) ); 
	?>"><?php endif; ?><img class="cat_img" src="<?php 
	echo $term[ 'image' ]; ?>" alt="<?php echo $term[ 'name' ]; ?>" /><?php 
	if ( $link_images ) : ?></a><?php 
	endif; ?>
	<?php /*if ( $show_description ) : ?>
		<p><?php term_description( $term[ 'id' ], $taxonomy ); ?></p>
	<?php endif; */?>
<?php } ?>