<?php
/* !BLOG POST GALLERIES */
/*---------------------------------------------------*/
add_filter( 'use_default_gallery_style', '__return_false' );

/* !FEATURED IMAGE */
/*---------------------------------------------------*/
add_theme_support( 'post-thumbnails' );

/* !IMPROVE JPEG QUALITY */
/*---------------------------------------------------*/

function jpeg_quality_callback($arg)
{
return (int)100;
}

add_filter('jpeg_quality', 'jpeg_quality_callback');

/* !MENUS */
/*---------------------------------------------------*/

function register_the_menus() {
  register_nav_menus(
    array( 	'mainNav' => __( 'Main Navigation' ),
    		'rightsNav' => __( 'Right page buttons' )
    	)
  );
}
add_action( 'init', 'register_the_menus' );


class rights_walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth, $args)
	{
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . ' column colx2"';
		
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
		$description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';
		
		if($depth != 0)
		{
		         $description = $append = $prepend = "";
		}

		$item_output = $args->before;
		$item_output .= '<a class="button_rights"'. $attributes .'>';
		$item_output .= $args->link_before;
		$item_output .= $item->title;
		$item_output .= $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		//$output = print_r($item,true);
	}
}


// As of WP 3.1.1 addition of classes for css styling to parents of custom post types doesn't exist.
// We want the correct classes added to the correct custom post type parent in the wp-nav-menu for css styling and highlighting, so we're modifying each individually...
// The id of each link is required for each one you want to modify
// Place this in your WordPress functions.php file

function remove_parent_classes($class)
{
  // check for current page classes, return false if they exist.
	return ($class == 'current_page_item' || $class == 'current_page_parent' || $class == 'current_page_ancestor'  || $class == 'current-menu-item') ? FALSE : TRUE;
}

function add_class_to_wp_nav_menu($classes)
{
     switch (get_post_type())
     {
     	case 'roto_book':
     		// we're viewing a custom post type, so remove the 'current_page_xxx and current-menu-item' from all menu items.
     		$classes = array_filter($classes, "remove_parent_classes");

     		// add the current page class to a specific menu item (replace ###).
     		if (in_array('menu-item-124', $classes))
     		{
     		   $classes[] = 'current_page_parent';
     		   $classes[] = 'menu-item-books';
     		}
     	break;


      // add more cases if necessary and/or a default
     }
	return $classes;
}
add_filter('nav_menu_css_class', 'add_class_to_wp_nav_menu');

add_filter('wp_nav_menu', 'add_slug_class_to_menu_item');
function add_slug_class_to_menu_item($output){
	$ps = get_option('permalink_structure');
	if(!empty($ps)){
		$idstr = preg_match_all('/<li id="menu-item-(\d+)/', $output, $matches);
		foreach($matches[1] as $mid){
			$id = get_post_meta($mid, '_menu_item_object_id', true);
			$slug = basename(get_permalink($id));
			$output = preg_replace('/menu-item-'.$mid.'">/', 'menu-item-'.$mid.' menu-item-'.$slug.'">', $output, 1);
		}
	}
	return $output;
}

//Add 'last' class to menu items
function add_last_item_class( $items )
{
	end($items);
	$items[key($items)]->classes[] = 'last';
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'add_last_item_class' );

/* !SIDEBARS */
/*---------------------------------------------------*/

register_sidebar( array(
	'name' => 'Blog sidebar',
	'id' => 'blog_sidebar',
	'description' => '',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
) );

/* !EXCERPTS & READ MORE LINK */
/*---------------------------------------------------*/

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/* !COMMENTS */
/*---------------------------------------------------*/

function custom_comment($comment, $args, $depth) 
{
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<?php
			if(function_exists('get_avatar')) { echo get_avatar($comment, '40'); } 
			if ($comment->comment_approved == '0') : 
			?>
				<em><?php _e('Your comment is awaiting moderation.') ?></em>
				<br />
			<?php 
			endif; 
			?>
			<p class="commentMeta"><small><?php printf(__('Posted by %s'), get_comment_author_link()) ?> on <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?></small></p>
			<div class="commentText"><?php comment_text() ?></div>
			
			<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
		</div>
	<?php
}

/* !BREADCRUMBS */
/*---------------------------------------------------*/

//Breadcrumb args
function bc_args( $args ) {
	$args = array(	'include_home'    => false,
					'include_root'    => false);
	return $args;
}

/* !PAGINATION */
/*---------------------------------------------------*/

//Pagination
function kriesi_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}

/* !CUSTOM POST TYPES */
/*---------------------------------------------------*/

//!post types
add_action('init', 'create_custom_post_types');
 
function create_custom_post_types() 
{
    register_post_type( 'roto_book',
        array(
            'labels' => array(
                'name' => 'Books',
                'singular_name' => 'Book',
                'add_new' => 'Add new',
                'add_new_item' => 'Add new book',
                'edit' => 'Edit',
                'edit_item' => 'Edit book',
                'new_item' => 'New book',
                'view' => 'View',
                'view_item' => 'View book',
                'search_items' => 'Search books',
                'not_found' => 'No books found',
                'not_found_in_trash' => 'No books found in the bin',
                'parent' => 'Parent book'
            ),
            'rewrite' => array( 'slug' => 'book','with_front'=>false ),
            'public' => true,
            'menu_position' => 5,
            'supports' => array( 'title', 'editor', 'thumbnail' ),
            'has_archive' => true,
            'show_in_nav_menus' => true
        )
    );
    register_post_type( 'roto_review',
        array(
            'labels' => array(
                'name' => 'Book Reviews',
                'singular_name' => 'Book review',
                'add_new' => 'Add new',
                'add_new_item' => 'Add new review',
                'edit' => 'Edit',
                'edit_item' => 'Edit review',
                'new_item' => 'New review',
                'view' => 'View',
                'view_item' => 'View review',
                'search_items' => 'Search reviews',
                'not_found' => 'No reviews found',
                'not_found_in_trash' => 'No reviews found in the bin',
                'parent' => 'Parent review'
            ),
            'exclude_from_search' => true,
            'public' => true,
            'menu_position' => 6,
            'supports' => array( 'title','editor' ),
            'has_archive' => false
        )
    );
    register_post_type( 'roto_contact',
        array(
            'labels' => array(
                'name' => 'Contacts',
                'singular_name' => 'Contact',
                'add_new' => 'Add new',
                'add_new_item' => 'Add new contact',
                'edit' => 'Edit',
                'edit_item' => 'Edit contact',
                'new_item' => 'New contact',
                'view' => 'View',
                'view_item' => 'View contact',
                'search_items' => 'Search contacts',
                'not_found' => 'No contacts found',
                'not_found_in_trash' => 'No contacts found in the bin',
                'parent' => 'Parent contact'
            ),
            'public' => true,
            'menu_position' => 7,
            'supports' => array( 'title' ),
            'has_archive' => true
        )
    );
    register_post_type( 'roto_download',
        array(
            'labels' => array(
                'name' => 'Downloads',
                'singular_name' => 'Download',
                'add_new' => 'Add new',
                'add_new_item' => 'Add new download',
                'edit' => 'Edit',
                'edit_item' => 'Edit download',
                'new_item' => 'New download',
                'view' => 'View',
                'view_item' => 'View download',
                'search_items' => 'Search downloads',
                'not_found' => 'No downloads found',
                'not_found_in_trash' => 'No downloads found in the bin',
                'parent' => 'Parent download'
            ),
            'public' => true,
            'menu_position' => 8,
            'supports' => array( 'title','editor' ),
            'has_archive' => true
        )
    );
}

//!custom menu icons
add_action( 'admin_head', 'cpt_icons' );
function cpt_icons() 
{
    ?>
    <style type="text/css" media="screen">
        #menu-posts-roto_book .wp-menu-image {
            background: url(<?php bloginfo('template_url') ?>/images/book-open-bookmark.png) no-repeat 6px -17px !important;
        }
        #menu-posts-roto_review .wp-menu-image {
            background: url(<?php bloginfo('template_url') ?>/images/balloon-quotation.png) no-repeat 6px -17px !important;
        }
        #menu-posts-roto_contact .wp-menu-image {
            background: url(<?php bloginfo('template_url') ?>/images/users.png) no-repeat 6px -17px !important;
        }
        #menu-posts-roto_book:hover .wp-menu-image, #menu-posts-roto_book.wp-has-current-submenu .wp-menu-image,
        #menu-posts-roto_review:hover .wp-menu-image, #menu-posts-roto_review.wp-has-current-submenu .wp-menu-image,
        #menu-posts-roto_contact:hover .wp-menu-image, #menu-posts-roto_contact.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px!important;
        }
        #icon-edit.icon32-posts-roto_book {
	        background: url(<?php bloginfo('template_url') ?>/images/book-open-bookmark-32.png) no-repeat 0 0;
        }
        #icon-edit.icon32-posts-roto_review {
	        background: url(<?php bloginfo('template_url') ?>/images/balloon-quotation-32.png) no-repeat 0 0;
        }
        #icon-edit.icon32-posts-roto_contact {
	        background: url(<?php bloginfo('template_url') ?>/images/user-32.png) no-repeat 0 0;
        }
    </style>
<?php 
}

//!categories
function create_roto_taxonomies() {
	register_taxonomy(
		'roto_book_cat',
		array('roto_book'),
		array(	'public' => true,
				'hierarchical'=>true,
				'rewrite' => array( 'slug' => 'books','with_front'=>false ),
				'labels'=>array('name'=>'Book categories',
								'singular_name'=>'Book category',
								'search_items' => 'Search categories',
								'popular_items' => 'Popular categories',
								'all_items' => 'All categories',
								'parent_item' => 'Parent category',
								'parent_item_colon' => 'Parent category:',
								'edit_item' => 'Edit category',
								'update_item' => 'Update category',
								'add_new_item' => 'Add new category',
								'new_item_name' => 'New category name'
								)
			)
	);
	register_taxonomy(
		'roto_book_tag',
		array('roto_book'),
		array(	'public' => true,
				'hierarchical'=>false,
				'labels'=>array('name'=>'Book tags',
								'singular_name'=>'Book tag',
								'search_items' => 'Search tags',
								'popular_items' => 'Popular tags',
								'all_items' => 'All tags',
								'edit_item' => 'Edit tag',
								'update_item' => 'Update tag',
								'add_new_item' => 'Add new tag',
								'new_item_name' => 'New tag name'
								)
			)
	);
	register_taxonomy(
		'roto_book_subject_tag',
		array('roto_book'),
		array(	'public' => true,
				'hierarchical'=>false,
				'labels'=>array('name'=>'Book subjects',
								'singular_name'=>'Book subject',
								'search_items' => 'Search subjects',
								'popular_items' => 'Popular subjects',
								'all_items' => 'All subjects',
								'edit_item' => 'Edit subject',
								'update_item' => 'Update subject',
								'add_new_item' => 'Add new subject',
								'new_item_name' => 'New subject name'
								)
			)
	);
	register_taxonomy(
		'roto_book_publisher_tag',
		array('roto_book'),
		array(	'public' => true,
				'hierarchical'=>false,
				'labels'=>array('name'=>'Book publishers',
								'singular_name'=>'Book publisher',
								'search_items' => 'Search publishers',
								'popular_items' => 'Popular publishers',
								'all_items' => 'All publishers',
								'edit_item' => 'Edit publisher',
								'update_item' => 'Update publisher',
								'add_new_item' => 'Add new publisher',
								'new_item_name' => 'New publisher name'
								)
			)
	);
	register_taxonomy(
		'roto_contact_cat',
		array('roto_contact'),
		array(	'public' => true,
				'hierarchical'=>true,
				'rewrite' => array( 'slug' => 'contacts','with_front'=>false ),
				'labels'=>array('name'=>'Contact categories',
								'singular_name'=>'Contact category',
								'search_items' => 'Search categories',
								'popular_items' => 'Popular categories',
								'all_items' => 'All categories',
								'parent_item' => 'Parent category',
								'parent_item_colon' => 'Parent category:',
								'edit_item' => 'Edit category',
								'update_item' => 'Update category',
								'add_new_item' => 'Add new category',
								'new_item_name' => 'New category name'
								)
			)
	);
	register_taxonomy(
		'roto_download_cat',
		array('roto_download'),
		array(	'public' => true,
				'hierarchical'=>true,
				'rewrite' => array( 'slug' => 'dloads','with_front'=>true ),
				'labels'=>array('name'=>'Download categories',
								'singular_name'=>'Download category',
								'search_items' => 'Search categories',
								'popular_items' => 'Popular categories',
								'all_items' => 'All categories',
								'parent_item' => 'Parent category',
								'parent_item_colon' => 'Parent category:',
								'edit_item' => 'Edit category',
								'update_item' => 'Update category',
								'add_new_item' => 'Add new category',
								'new_item_name' => 'New category name'
								)
			)
	);

}
add_action('init','create_roto_taxonomies');

/* !META BOXES (requires plugin) */
/*---------------------------------------------------*/
$prefix = 'roto_';

global $meta_boxes;

$meta_boxes = array();

//For books
$meta_boxes[] = array(
	'id' => 'book_details',
	'title' => 'Book information',
	'pages' => array( 'roto_book' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		// AUTHOR NAME
		array(
			'name'  => 'Author name',
			'id'    => "{$prefix}author_name",
			'type'  => 'text',
		),
		// ABOUT THE AUTHOR
		array(
			'name'  => 'About the author',
			'id'   => "{$prefix}about_author",
			'type' => 'wysiwyg',
			// Editor settings, see wp_editor() function: look4wp.com/wp_editor
			'options' => array(
				'textarea_rows' => 10,
				'teeny'         => true,
				'media_buttons' => false,
			),
		),
		/*
array(
			'name'  => 'Publisher (Not shown)',
			'id'    => "{$prefix}book_publisher",
			'type'  => 'text'
		),
		array(
			'name'  => 'Subject (Not shown)',
			'id'    => "{$prefix}book_subject",
			'type'  => 'text'
		),
*/
		array(
			'name'  => 'ISBN',
			'id'    => "{$prefix}book_isbn",
			'type'  => 'text'
		),
		array(
			'name'  => 'Page count',
			'id'    => "{$prefix}book_page_count",
			'type'  => 'text'
		),
		array(
			'name'  => 'Word count',
			'id'    => "{$prefix}book_word_count",
			'type'  => 'text'
		),
		array(
			'name'  => 'Image count',
			'id'    => "{$prefix}book_img_count",
			'type'  => 'text'
		),
		array(
			'name'  => 'Dimensions',
			'id'    => "{$prefix}book_dimensions",
			'type'  => 'text'
		),
		array(
			'name'  => 'Rights sold',
			'id'    => "{$prefix}book_rights_sold",
			'type'  => 'text'
		),
		array(
			'name'  => 'Available for translation',
			'id'    => "{$prefix}book_translation",
			'type'  => 'text'
		),
		array(
			'name'  => 'Amazon UK',
			'id'    => "{$prefix}book_amazon_uk",
			'type'  => 'text'
		),
		array(
			'name'  => 'Amazon USA',
			'id'    => "{$prefix}book_amazon_usa",
			'type'  => 'text'
		),
		// COVER IMAGE
		array(
			'name' => 'Main cover image',
			'id'   => "{$prefix}book_cover",
			'type' => 'thickbox_image',
		),
		// FOREIGN COVERS
		array(
			'name'             => 'Cover gallery',
			'id'               => "{$prefix}cover_gallery",
			'type'             => 'thickbox_image',
			//'max_file_uploads' => 4,
		),
		//ISSUU (or whatever) EMBED CODE
		array(
			'name' => 'Preview spreads',
			'desc' => 'ISSUU (or similar) embed code',
			'id'   => "{$prefix}preview",
			'type' => 'textarea',
			'rows' => '10'
		),
		array(
			'name' => 'ISSUU direct link',
			'id'   => "{$prefix}issuu_link",
			'type' => 'text',
			'size' => 100
		),
	)
);
//For book reviews
$meta_boxes[] = array(
	'id' => 'review_source',
	'title' => 'Sources',
	'pages' => array( 'roto_review' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		// AUTHOR NAME
		array(
			'name'  => 'Reviewer',
			'id'    => "{$prefix}reviewer",
			'type'  => 'text',
		),
		array(
			'name'  => 'Web link',
			'id'    => "{$prefix}review_url",
			'type'  => 'text',
		)
	)
);
//For contacts
$meta_boxes[] = array(
	'id' => 'contact_details',
	'title' => 'Details',
	'pages' => array( 'roto_contact' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		// POSITION
		array(
			'name'  => 'Position',
			'id'    => "{$prefix}contact_position",
			'type'  => 'text',
		),
		//EMAIL
		array(
			'name'  => 'Email',
			'id'    => "{$prefix}contact_email",
			'type'  => 'text',
		),
		//AREAS
		array(
			'name'  => 'Areas covered',
			'id'    => "{$prefix}contact_areas",
			'type'  => 'textarea',
			'rows'	=> '2'
		)
	)
);
//For downloads
$meta_boxes[] = array(
	'id' => 'download_file',
	'title' => 'File for download',
	'pages' => array( 'roto_download' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'File',
			'id'   => "{$prefix}download_file",
			'type' => 'file',
		)
	)
);

function roto_register_meta_boxes()
{
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	foreach ( $meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
add_action( 'admin_init', 'roto_register_meta_boxes' );


/* !RELATED CONTENT*/
/*---------------------------------------------------*/

function set_related_content() {
	p2p_register_connection_type( array(
		'name' => 'reviews_to_books',
		'from' => 'roto_review',
		'to' => 'roto_book'
	) );
	p2p_register_connection_type( array(
		'name' => 'related_books',
		'from' => 'roto_book',
		'to' => 'roto_book',
		'reciprocal' => true
	) );
}
add_action( 'p2p_init', 'set_related_content' );

/* !SLIDESHOWS */
/*---------------------------------------------------*/

// Get attached images & spits out a list of them.
function custom_image_gallery($size = 'full', $limit = '0', $offset = '0',$post_id='',$title=true)
{
	$output = '';
    global $post;
    $post_id = $post_id == '' ? $post->ID : $post_id;
    $images = get_children( array('post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'rand') );
    if ($images) 
    {
        $num_of_images = count($images);
        if ($offset > 0) : $start = $offset--; else : $start = 0; endif;
        if ($limit > 0) : $stop = $limit+$start; else : $stop = $num_of_images; endif;
        $i = 0;
        foreach ($images as $image) 
        {
            if ($start <= $i and $i < $stop) 
            {
	            $img_title = $image->post_title;   // title.
	            $img_description = $image->post_content; // description.
	            $img_caption = $image->post_excerpt; // caption.
	            $img_url = wp_get_attachment_url($image->ID); // url of the full size image.
	            $preview_array = image_downsize( $image->ID, $size );
	            $img_preview = $preview_array[0]; // thumbnail or medium image to use for preview.
	            $output .= '<div class="slide">';
	            $output .= "<a href=\"#\"><img src=\"$img_preview\" alt=\"$img_caption\"";
	            $output .= $title == true ? " title=\"$img_title\">" : "";
	            $output .= "</a>\n";
	            $output .= '</div>';
            }
            $i++;
        }
    }
    return $output;
}

/* !SEARCHING*/
/*---------------------------------------------------*/

//!Add an extra argument to wp_query to search by title
add_filter( 'posts_where', 'title_like_posts_where', 10, 2 );
function title_like_posts_where( $where, &$wp_query ) {
    global $wpdb;
    if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $post_title_like ) ) . '%\'';
    }
    return $where;
}


function imageResize($width, $height, $target, $base='') 
{
	switch($base)
	{
		case 'width':
			$percentage = ($target / $width);
		break;
		case 'height':
			$percentage = ($target / $height);
		break;
		default:
			if ($width > $height) 
			{
				$percentage = ($target / $width);
			} 
			else 
			{
				$percentage = ($target / $height);
			}
		break;
	}
	$width = round($width * $percentage);
	$height = round($height * $percentage);
	return "width=\"$width\" height=\"$height\"";
} 


if (!function_exists('wwp_posttype_breadcrumb')){
	function wwp_posttype_breadcrumb( $args = '',$seperator = ">"){

	//Sort out some URLS
	$find = array("books/back-list","books/front-list");
	$replace = array("back-list","books");

    $term = get_term($GLOBALS['wp_query']->get_queried_object_id(), get_query_var('taxonomy'));
    $term_name = $term->name;
    $term_parent = $term->parent;
    while($term_parent){
        $term = get_term($term_parent, get_query_var('taxonomy'));
        $term_parent = $term->parent;
        //echo $term->name;
        $term_parents[] = array('name'=>$term->name, 'url'=>get_term_link((int)$term->term_id, get_query_var('taxonomy')));
    }
    if(!empty($term_parents)){
        $term_parents = array_reverse($term_parents);
        foreach($term_parents as $term){
            $output[] =  '<a href="'.$term['url'].'">'.$term['name'].'</a>';
        };
    }

	if (!empty($output)):
		$output = join( " ".$seperator." ", $output );
	endif;
	
	return str_replace($find,$replace,$output);
	}
}

?>