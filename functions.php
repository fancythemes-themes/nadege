<?php
/**
 * Nadege functions and definitions
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
 * 
 * @package Nadege
 * @since Nadege 1.0
 */

if ( ! function_exists( 'nadege_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own nadege_setup() function to override in a child theme.
 *
 * @since Nadege 1.0
 */
function nadege_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/nadege
	 * If you're building a theme based on Nadege, use a find and replace
	 * to change 'nadege' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'nadege' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 *
	 *  @since Nadege 1.0
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 300,
		'width'       => 300,
		'flex-height' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'      => esc_html__( 'Primary Menu', 'nadege' ),
		'social'       => esc_html__( 'Social Links Menu', 'nadege' ),
		'footer-menu'  => esc_html__( 'Footer Menu', 'nadege' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', nadege_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // nadege_setup
add_action( 'after_setup_theme', 'nadege_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Nadege 1.0
 */
function nadege_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nadege_content_width', 840 );
}
add_action( 'after_setup_theme', 'nadege_content_width', 0 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Nadege 1.0
 */
function nadege_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'nadege' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'nadege' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Full Width Before Content', 'nadege' ),
		'description'	=> esc_html__( 'Placed on the top before main content. Best use for featured posts.', 'nadege'),
		'id'            => 'sidebar-2',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Full Width After Content', 'nadege' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 1', 'nadege' ),
		'id'            => 'footer-widget-1',
		'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 2', 'nadege' ),
		'id'            => 'footer-widget-2',
		'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 3', 'nadege' ),
		'id'            => 'footer-widget-3',
		'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 4', 'nadege' ),
		'id'            => 'footer-widget-4',
		'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'nadege_widgets_init' );

if ( ! function_exists( 'nadege_fonts_url' ) ) :
/**
 * Register Google fonts for Nadege.
 *
 * Create your own nadege_fonts_url() function to override in a child theme.
 *
 * @since Nadege 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function nadege_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Roboto, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'nadege' ) ) {
		$fonts[] = 'Roboto:400,700';
	}


	/* translators: If there are characters in your language that are not supported by Source Serif Pro, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Source Serif Pro font: on or off', 'nadege' ) ) {
		$fonts[] = 'Source Serif Pro:400,400i,700,700i';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Nadege 1.0
 */
function nadege_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'nadege_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Nadege 1.0
 */
function nadege_scripts() {
	// Add custom fonts, used in the main stylesheet.
	//wp_enqueue_style( 'nadege-fonts', nadege_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	//wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'nadege-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'nadege-ie', get_template_directory_uri() . '/css/ie.css', array( 'nadege-style' ), '20160816' );
	wp_style_add_data( 'nadege-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'nadege-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'nadege-style' ), '20160816' );
	wp_style_add_data( 'nadege-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'nadege-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'nadege-style' ), '20160816' );
	wp_style_add_data( 'nadege-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	wp_enqueue_script( 'nadege-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'nadege-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'nadege-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '20160816' );

	wp_enqueue_script( 'nadege-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160816', true );

	wp_enqueue_script( 'nadege-svgxuse', get_template_directory_uri() . '/js/svgxuse.min.js', array(), '1.2.4' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'nadege-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160816' );
	}

	wp_enqueue_script( 'nadege-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160816', true );

	wp_localize_script( 'nadege-script', 'screenReaderText', array(
		'expand'   => esc_html__( 'expand child menu', 'nadege' ),
		'collapse' => esc_html__( 'collapse child menu', 'nadege' ),
		'loadMoreText' => esc_html__( 'Load More', 'nadege' ),
		'loadingText'  => esc_html__( 'Loading...', 'nadege' ),
	) );

	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '20160816', true );

	$featured_posts_type =  get_theme_mod('featured_posts_type', 'carousel');
	wp_localize_script( 'nadege-script', 'sliderOptions', array(
		'slideType'     => $featured_posts_type,	
		'slideshowSpeed'	=> 5000,
		'prevText'			=> sprintf(
									'<span class="screen-reader-text">%1$s</span>%2$s',
									esc_html__('Previous', 'nadege'),
									nadege_svg_icon('arrow-left')
								 ),
		'nextText'			=> sprintf(
									'<span class="screen-reader-text">%1$s</span>%2$s',
									esc_html__('Next', 'nadege'),
									nadege_svg_icon('arrow-right')
								 ),
		'itemWidth'			=> ( $featured_posts_type == 'carousel' ) ? 300 : 0,
		'minItems'			=> ( $featured_posts_type == 'carousel' ) ? 3 : 1,
		'maxItems'			=> ( $featured_posts_type == 'carousel' ) ? 3 : 0
	) );
}
add_action( 'wp_enqueue_scripts', 'nadege_scripts' );


/**
 * Enqueues admin scripts and styles.
 *
 * @since Nadege 1.0
 */
function nadege_admin_enqueue_scripts( $hook ) {
	if ( $hook == 'widgets.php' ) {
		wp_enqueue_style( 'nadege-admin', get_template_directory_uri() . '/css/admin.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'nadege_admin_enqueue_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Nadege 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function nadege_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'nadege_body_classes' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

if ( class_exists( 'Jetpack') ) :
	/**
	 * Jetpack. Only include if Jetpack plugin installed.
	 *
	 */
	require get_template_directory() . '/inc/jetpack.php';
endif;

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer framework additions.
 */
require get_template_directory() . '/inc/customizer-simple.php';

/**
 * Customizer sanitazion callback functions.
 */
require get_template_directory() . '/inc/sanitize-callbacks.php';

/**
 * Posts widget.
 */
require get_template_directory() . '/inc/widgets/recent-posts.php';

if ( class_exists( 'StormTwitter' ) ) :
	/**
	 * Twitter widget. Only include when the oAuth Twitter Feed for Developer plugin installed
	 *
	 */
	require get_template_directory() . '/inc/widgets/twitter.php';
endif;

/**
 * Instagram widget.
 *
 */
require get_template_directory() . '/inc/widgets/instagram.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Nadege 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function nadege_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'nadege_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Nadege 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function nadege_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'nadege_post_thumbnail_sizes_attr', 10 , 3 );


/**
 * Replace the string 'icon_replace' on SVG use xlink:href attribute from wp_nav_menu's link_before argument by the escaped domain name from link url
 * the dot(.) on domain replaced by dash(-), eg. plus.google.com -> plus-google-com
 * so for the menu with URL linked to google plus domain will have SVG icon with use tag like
 * <use xlink:href="http://your-domain/wp-content/themes/fusion/icons/symbol-defs.svg#icon-social-plus-google-com"></use>
 *
 * see also function fusion_svg_icon() in the template-tags.php
 * see also the declaration of wp_nav_menu for theme location "social" in the header.php and footer.php
 *
 * @since Nadege 1.0
 *
 * @param string $item_output The menu item's starting HTML output.
 * @param object $item		Menu item data object.
 * @param int	$depth	   Depth of menu item. Used for padding.
 * @param array  $args		An array of arguments. @see wp_nav_menu()
 */
function nadege_social_menu_item_output ( $item_output, $item, $depth, $args ) {
	$parsed_url = parse_url( $item->url);
	$class = ! empty( $parsed_url['host'] ) ? nadege_map_domain_class( $parsed_url['host'] ) : '';
	$output = str_replace('icon_replace', 'social-' . $class, $item_output);
	return $output;
}

/**
 * Extract domain name without tld, used as class name or icon identifier
 * Used in function nadege_social_menu_item_output()
 *
 * @since Nadege 1.0
 *
 * @param string $domain a domain name
 */
function nadege_map_domain_class( $domain ) {
	$class = '';
	if ( strpos( 'plus.google.com', $domain ) !== false ) {
		$class = 'google-plus-1';
	} else {
		$texts = explode('.', $domain );
		$class = $texts[count( $texts ) - 2];
	}
	return $class;
}

/**
 * Helper for kses that only span tag allowed
 *
 * @since Nadege 1.0
 */
function nadege_only_allow_span() {
	$allowed_tags = 
		array(
			'span' => array(
				'class' => array(),
			),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
		);

	return $allowed_tags;

}

/**
 * Setup a font controls & settings for Easy Google Fonts plugin (if installed)
 *
 * @since Nadege 1.0
 *
 * @param array $options Default control list by the plugin.
 * @return array Modified $options parameter to applied in filter 'tt_font_get_option_parameters'.
 */
function nadege_easy_google_fonts($options) {

	// Just replace all the plugin default font control

	unset(  $options['tt_default_body'],
			$options['tt_default_heading_2'],
			$options['tt_default_heading_3'],
			$options['tt_default_heading_4'],
			$options['tt_default_heading_5'],
			$options['tt_default_heading_6'],
			$options['tt_default_heading_1']
		);

	$new_options = array(
		
		'nadege_default_body' => array(
			'name'        => 'nadege_default_body',
			'title'       => esc_html__( 'Body & Paragraphs', 'nadege' ),
			'description' => esc_html__( "Please select a font for the theme's body and paragraph text", 'nadege' ),
			'properties'  => array( 'selector' => apply_filters( 'nadege_default_body_font', 'body, input, select, textarea, blockquote cite, .entry-footer, .site-main div.sharedaddy h3.sd-title' ) ),
		),

		'nadege_default_menu' => array(
			'name'        => 'nadege_default_menu',
			'title'       => esc_html__( 'Menu', 'nadege' ),
			'description' => esc_html__( "Please select a font for the theme's menu styles", 'nadege' ),
			'properties'  => array( 'selector' => apply_filters( 'nadege_default_heading', '.main-navigation' ) ),
		),

		'nadege_default_entry_title' => array(
			'name'        => 'nadege_default_entry_title',
			'title'       => esc_html__( 'Entry Title', 'nadege' ),
			'description' => esc_html__( "Please select a font for the theme's Entry title styles", 'nadege' ),
			'properties'  => array( 'selector' => apply_filters( 'nadege_default_menu_font', '.site-title, .entry-title, .post-navigation .post-title, .comment-meta .fn, .page-title, .site-main #jp-relatedposts .jp-relatedposts-items-visual h4.jp-relatedposts-post-title a, .site-main #jp-relatedposts h3.jp-relatedposts-headline, button, input[type="button"], input[type="reset"], input[type="submit"], .load-more a ' ) ),
		),

		'nadege_default_entry_meta' => array(
			'name'        => 'nadege_default_entry_meta',
			'title'       => esc_html__( 'Entry Meta', 'nadege' ),
			'description' => esc_html__( "Please select a font for the theme's Entry meta styles", 'nadege' ),
			'properties'  => array( 'selector' => apply_filters( 'nadege_default_meta_font', '.entry-meta, .site-info, .site-breadcrumbs, .posted-on, .post-navigation .meta-nav, .comment-metadata, .pingback .edit-link, .comment-reply-link, .site-content #jp-relatedposts .jp-relatedposts-items .jp-relatedposts-post .jp-relatedposts-post-date, .site-content #jp-relatedposts .jp-relatedposts-items .jp-relatedposts-post .jp-relatedposts-post-context, .site-featured-posts .more-featured-title, .page-header .archive-title-pre' ) ),
		),

		'nadege_default_widget_title' => array(
			'name'        => 'nadege_default_widget_title',
			'title'       => esc_html__( 'Widget Title', 'nadege' ),
			'description' => esc_html__( "Please select a font for the theme's Widget title styles", 'nadege' ),
			'properties'  => array( 'selector' => apply_filters( 'nadege_default_widget_title_font', '.widget .widget-title, .widget-recent-posts .tab-control a span, .load-more a, .comments-title, .comment-reply-title, #page .site-main #jp-relatedposts h3.jp-relatedposts-headline, .site-main #jp-relatedposts h3.jp-relatedposts-headline em, .widget-recent-posts .image-medium.sort-comment_count li .post-thumbnail:before  ' ) ),
		),


	);

	return array_merge( $options, $new_options);
}
add_filter( 'tt_font_get_option_parameters', 'nadege_easy_google_fonts', 10 , 1 );
