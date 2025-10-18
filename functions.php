<?php
/**
 * solo functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package solo
 * @since 1.0.3
 */
if ( !defined ( 'SOLO_VER' ) ) { define ( 'SOLO_VER', time() ); }
// FAST LOADER References ( find @#id in DocBlocks )
// ------------------------- Actions ---------------------------
// A1
add_action( 'after_setup_theme',        'solo_theme_setup' );
// A2
add_action( 'after_setup_theme',        'solo_theme_content_width', 0 );
// A3
add_action( 'wp_enqueue_scripts',       'solo_theme_enqueue_styles' );
// A4
add_action( 'widgets_init',             'solo_theme_widgets_init' );
// A5
add_action( 'admin_init',               'solo_theme_add_editor_styles' );
// A6
add_action( 'solo_render_attachment',   'solo_render_attachment_link' );
// A7
add_action( 'solo_excerpt_attachment',  'solo_excerpt_attachment_toanchor' );
// A10
add_action( 'solo_heading_metadata',    'solo_heading_metadata_render' );
// A11
add_action( 'solo_page_comments_allow', 'solo_page_comments_open_ornot');
// A12
add_action( 'solo_featured_excerpt',    'solo_featured_excerpt_maybe' );
// A8
add_action( 'solo_header_declaration',  'solo_header_declaration_render' );
// A8
add_action( 'solo_menu_text',           'solo_menu_text_render' );
// A9
add_action( 'solo_check_pagination',    'solo_check_pagination_pre' );
// ------------------------- Filters -----------------------------
// F2
add_filter( 'widget_tag_cloud_args',    'solo_theme_widget_tag_cloud_args' );
// F3
add_filter('excerpt_more',              'solo_custom_excerpt_more'); 
// F4
add_filter( 'body_class',               'solo_theme_heropage_class' );
// F5
add_filter('body_class',                'solo_theme_browser_body_class');
// F6
add_filter( 'body_class',               'solo_theme_bloglayout_class' );
// F7
add_filter( 'the_content',              'solo_render_excerpt_toblog' );
/**
 * Add backwards compatibility support for wp_body_open function.
 */
if ( ! function_exists( 'wp_body_open' ) ) {
    
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

/** #A1
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own solo_setup() function to override in a child theme.
 *
 * @since 1.0.2
 */
if ( ! function_exists( 'solo_theme_setup' ) ) :

	function solo_theme_setup() {
		/*
		* Make theme available for translation.
		* Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentysixteen
		* If you're building a theme based on solo, use a find and replace
		* to change 'solo' to the name of your theme in all the template files
		*/
		load_theme_textdomain( 'solo', get_template_directory_uri() . '/languages' );

		/* a.
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		/* b.
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded "title" tag in the document head, and expect WordPress to provide it for us.
		*
		* Enable support for Post Thumbnails on posts and pages.
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		// a. Deprecated after CP 2.2
		/* add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)); */

		// b.
		add_theme_support( 'title-tag' );
    	add_theme_support( 'automatic-feed-links' ); // rss feederz
    
		







		add_theme_support( 'post-thumbnails', array( 'post', 'page') );
		// register new phone-landscape featured image size. @width, @height, and @crop
		add_image_size( 'solo-featured', 520, 300, false);   
		add_image_size( 'solo-hero-image', 1080, '' );
		/*
		 * Enable support for custom logo.
		 *
		 *  @since 1.0
		 */
		add_theme_support( 'custom-logo' );

		//page background image and color support
		add_theme_support( 'custom-background', 
			array( 
		   'default-color'      => '#fcfcfc',
		   'default-image'       => '',
		   'wp-head-callback'     => '_custom_background_cb',
		   'admin-head-callback'   => '',
		   'admin-preview-callback' => ''
		) );
		add_theme_support( 'custom-logo' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary-menu' => __( 'Primary Main Menu', 'solo' ),
			)
		);
	}
endif;


/** #A2
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since 1.0
 */
function solo_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'solo_content_width', 520 );
}

/** #A3
 * Enqueues scripts and styles.
 *
 * @since 1.0.2 removed hambrg.js
 */
function solo_theme_enqueue_styles() {
	wp_enqueue_style( 
		'solo-style', 
		get_stylesheet_directory_uri() .'/style.css',
		array(),
		SOLO_VER
	);
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 
			'comment-reply' 
		);
	}

    wp_enqueue_script( 
		'solo-script', 
		get_template_directory_uri() . '/rels/solo-script.js', 
		array(), 
		SOLO_VER, 
		true 
	);
	/* wp_enqueue_script( 
		'solo-hamburger', 
		get_template_directory_uri() . '/rels/solo-hamburger.js', 
		array(), 
		SOLO_VER, 
		true 
	); */
}


/** #A4
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since 1.0
 */
function solo_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'solo' ),
			'id'            => 'sidebar-page',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'solo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Section One', 'solo' ),
			'id'            => 'footer-one',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'solo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Section Two', 'solo' ),
			'id'            => 'footer-two',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'solo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

    register_sidebar(
		array(
			'name'          => __( 'Footer Section Three', 'solo' ),
			'id'            => 'footer-three',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'solo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

/** #A5
 * Registers an editor stylesheet for the theme.
 *
 * @since 1.0.0
 */
function solo_theme_add_editor_styles() {

    add_editor_style( 'editor-style.css' );
}

/**
 * Support for logo upload, output. 
 *
 * @since 1.0.1 
 */
function solo_theme_custom_logo() {
    $output = '';

    if ( function_exists( 'the_custom_logo' ) ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo           = wp_get_attachment_image_src( $custom_logo_id , 'medium' );

        if ( has_custom_logo() ) {
            $output = '<div class="header-logo">
			<img src="'. esc_url( $logo[0] ) .'" alt="'. get_bloginfo( 'name' ) .'" 
			class="solo-attachment-small"/>
			</div>'; 
        } else { 
            $output = ''; 
        }
    }
        // Output sanitized in header to assure all html displays.
        return $output;
}

/** #A6
 * Attachment link for featured images
 *
 * @since 1.0.2
 * @return HTML
 */
function solo_render_attachment_link(){
?>  
    <figure class="linked-attachment-container">
    <a class="imgwrap-link"
       href ="<?php echo esc_url( get_attachment_link( get_post_thumbnail_id() ) ); ?>" 
       title="<?php the_title_attribute( 'before=Permalink to: &after=' ); ?>">
    <?php 
    the_post_thumbnail( 'solo-featured', array( 
            'itemprop' => 'image', 
            'class'  => 'solo-featured',
            'alt'  => get_attachment_link( get_post_thumbnail_id() )
        ) 
    ); ?></a>
    </figure><?php 
}

/** #A7
 * Attachment render for excerpts
 *
 * @since 1.0.2
 * @return HTML
 */

function solo_excerpt_attachment_toanchor(){

	?>                 
		<figure class="linked-attachment-container-sm">
		<a class="excerptwrap-link"
		   href ="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" 
		   title="<?php the_title_attribute( 'before=Permalink to: &after=' ); ?>">
		<?php 
		the_post_thumbnail( 'solo-featured', array( 
				'itemprop' => 'image', 
				'class'  => 'solo-featured',
				'alt'  => get_the_title()
			) 
		); ?></a>
		</figure><?php 
}

/** #A8
 * Render text if not empty
 *
 * @since 1.0.2
 * @return HTML
 */
function solo_menu_text_render(){
	$txt = get_theme_mod( 'solo_menu_text', '' );
	if ( '' != $txt ) {
		esc_html(
            printf( esc_attr__( '%s', 'solo' ), // phpcs:ignore WordPress.WP.I18n.NoEmptyStrings
                esc_attr( $txt )
            )
        );
	} else {
		
		return '';
	}
}

/** #A10
 * Metadata render for excerpts
 *
 * @since 1.0.0
 * @return HTML
 */
function solo_heading_metadata_render(){
	ob_start();

	the_title( sprintf( '<span class="post-title"><a href="%s" rel="bookmark">', 
			esc_attr( esc_url( get_permalink() ) ) 
		), '</a></span>' 
	); ?>
	<span class="solo-heading-meta">
	<small><?php esc_html_e('By: ', 'solo'); ?> <em><?php the_author(); ?></em>
	| <?php esc_html_e('Categorized as: ', 'solo'); ?> <em><?php the_category( ' &bull; ' ); ?></em>
	| <?php esc_html_e('Keys: ', 'solo'); ?><em> <?php the_tags( ' ' ); ?></em>
	| <?php esc_html_e('Added on: ', 'solo'); ?> <em><?php the_date(); ?></em></small>
	</span>
	<?php 
	$output = ob_get_clean();
	echo wp_kses_post( $output );
}

/** 
 * Customizer
 * suport footer background & text color
 * header background & color
 * page background & color
 */

/* Adding files here to apply to the following functions below */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/theme-page-options.php';

/** #A11
 * Check to allow comments on pages override.
 *
 * @since 1.0.0
 * @return HTML
 */
function solo_page_comments_open_ornot(){
	$pgcomm = false;
	$pgcomm = get_theme_mod( 'solo_pagecomment', false );
	if ( $pgcomm ) : 
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	} 
	endif;
}

/** #A12
 * Check to allow comments on pages override.
 *
 * @since 1.0.0
 * @return HTML
 */
function solo_featured_excerpt_maybe(){
	$excrpt = false;

	return $excrpt;
}
/** #A8
 * Render hero section
 * @since 1.0
 * @param string $himg Theme mod url of hero image.
 * @param string $hout Image inline as background.
 * @param string $htitle theme mod text
 * 
 */
function solo_header_declaration_render(){

	if ( get_theme_mods() )  : 
		$hrender  = get_theme_mod( 'solo_declare_render', true );
		if ( !$hrender ) return;
	endif;
		$cta_url  = get_theme_mod( 'solo_declare_calltourl', '' );
		$cta_text = get_theme_mod( 'solo_declare_calltotext', '' );
		$htitle   = get_theme_mod( 'solo_declare_title', '');
		$hheading = get_theme_mod( 'solo_declare_heading', '' );

	ob_start();	
	?>
	<div class="solo-declare-top">
		<div class="solo-declare-content">
		
		<?php 
		if( '' != $htitle ) {
    		echo '<p class="solo-declare-title">' . esc_html( $htitle ) . '</p>';
		}
		if( '' != $hheading ) {
			echo '<p class="solo-declare-heading">' . esc_html( $hheading ) . '</p>';
		} 
		?>
		<?php 
		if ( '' != $cta_text ) : ?>

			<div class="solo-declare-call-to-action">
				<span>
					<a class="button cta-tinyd" href="<?php echo esc_url( $cta_url ); ?>" 
						title="<?php echo esc_attr( $cta_text ); ?>"><?php echo esc_html( $cta_text ); ?></a>
				</span>
			</div> 

		<?php 
	    endif; ?>

		</div>
	</div>
	<?php
	$output = ob_get_clean();  
	echo wp_kses_post( $output );
}

/** #A9
 * Show prenav text if pagination
 * 
 * @since 1.0
 * @param string $prev_link Boolean
 * @param string $next_link Boolean
 */
function solo_check_pagination_pre(){
    $prev_link = get_previous_posts_link();
	$next_link = get_next_posts_link();
	
	if ($prev_link || $next_link) { 

	echo '<span class="prenav">' . esc_html__( 'More Pages', 'solo' ) . '</span>';
	} else { 

	echo '<span class="prenav">' . esc_html__( 'No more entries for this page.', 'solo' ) . '</span>';
	} 
}

/** #F2
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since 1.0
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function solo_theme_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}

/** #F3
 * Remove ellipsis and set read more text.
 * Dev note: Title attribute is not attribute realted, 
 * it is text from the theme_mod only. Only `get_the_title` would work
 * if you want the actual title of the post.
 */
function solo_custom_excerpt_more($link) {
    //make sure admin tables not effected
    if ( is_admin() ) {
		return $link;
	}
    $post = get_post();
    if( get_theme_mods() ) {
    $title = get_theme_mod( 'solo_readon_text_setting' );
    }
        $link = ' <a class="more-link" href="'. esc_url( get_permalink($post->ID) ) 
                . '" title="' . esc_attr( $title ) . '">' 
                . esc_html( $title ) .'</a>';
        return solo_sanitize_text( $link );
}

/** #F4
 * Adding body class to the hero wide template page
 * 
 * @since 1.0
 */
function solo_theme_heropage_class( $classes ) {
	if ( is_page_template( 'hero-page.php' ) ) {
        $classes[] = 'hero-page';
    }
	return $classes;
} 

/** #F5
 * Check if WordPress detected a specific browser and add body_class
 * 
 * @since 1.0
 * @param Global WP Browser detect
 * @return body class added to opening body tag
 */
function solo_theme_browser_body_class($classes) { 
    global $is_iphone, $is_chrome, $is_safari, $is_NS4, $is_opera, $is_macIE, 
		   $is_winIE, $is_gecko, $is_lynx, $is_IE, $is_edge;
  
	if ($is_iphone)     $classes[] ='iphone-safari';
	elseif ($is_chrome) $classes[] ='google-chrome';
	elseif ($is_safari) $classes[] ='safari';
	elseif ($is_NS4)    $classes[] ='netscape';
	elseif ($is_opera)  $classes[] ='opera';
	elseif ($is_macIE)  $classes[] ='mac-ie';
	elseif ($is_winIE)  $classes[] ='windows-ie';
	elseif ($is_gecko)  $classes[] ='firefox';
	elseif ($is_lynx)   $classes[] ='lynx';
	elseif ($is_IE)     $classes[] ='internet-explorer';
	elseif ($is_edge)   $classes[] ='ms-edge';
	else $classes[] = 'unknown-browser';
		
	return $classes;
} 

/** #F6
 * Adding body class to the blog page flex option
 * 
 * @since 1.0
 */
function solo_theme_bloglayout_class($classes){

	if ( !basename( get_page_template() ) === 'index.php' ) return $classes;
	
	if ( get_theme_mods() ) : 
		$dloop = get_theme_mod( 'solo_blog_layout' );

		if ( 'row' == $dloop ) {
        	$classes[] = 'dancer-loop-horizontal';
		}

	endif;
	
	return $classes;
} 

/** #F7
 * Add excerpt to Article headings 
 * @since 1.0.0
 */
function solo_render_excerpt_toblog( $content ) {

	if ( is_home() || ( is_category() || is_archive() ) ) : 
		$rdmore = 'View Article';
		$text      = strip_shortcodes( $content );
		$text      = str_replace( ']]>', ']]&gt;', $text ); // phpcs:ignore Generic.Strings.UnnecessaryStringConcat
		$excerpt_length = apply_filters( 'excerpt_length', 55 );
		$excerpt_more   = apply_filters( 'excerpt_more', ' ' . '[...]' ); // phpcs:ignore Generic.Strings.UnnecessaryStringConcat.Found
		$words              = preg_split( "/[\n\r\t ]+/", 
					$text, 
					$excerpt_length + 1, 
					PREG_SPLIT_NO_EMPTY
					);
					//$trsr = printf( __( '%s', 'solo' ), $rdmore );
					
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = wp_kses_post( $text . $excerpt_more );
			
		} else {
			$text = implode(' ', $words);
		}  
		      
		return $text . '<a href="'.esc_attr( esc_url( get_permalink() ) ) .'" 
				rel="bookmark"><span class="permalnk">
				<em>[' . esc_html(  $rdmore ) . '...]</em></span></a>';
	endif;
	
	    	return $content;

}
