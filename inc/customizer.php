<?php
/**
 * Nadege Customizer functionality
 *
 * 
 * @package Nadege
 * @since Nadege 1.0
 */
function nadege_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'				=> '.site-title a',
			'container_inclusive'	=> false,
			'render_callback'     	=> 'nadege_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' 				=> '.site-description',
			'container_inclusive' 	=> false,
			'render_callback'     	=> 'nadege_customize_partial_blogdescription',
		) );
	}

	// Section : Posts Options
	$wp_customize->add_section('posts_options', array (
		'title'		 => esc_html__('Posts Options', 'nadege'),
	) );

	// Section : Footer Options
	$wp_customize->add_section('footer_options', array (
		'title'		 => esc_html__('Footer Options', 'nadege'),
	) );

	//$wp_customize->remove_setting('background_color');
	$wp_customize->remove_control('background_color');
	//$wp_customize->remove_setting('header_textcolor');
	$wp_customize->remove_control('header_textcolor');
}
add_action( 'nadege_before_customize_wrapper', 'nadege_customize_register' );

/**
 * List of customizer settings
 * See function nadege_customizer_wrapper_settings at customizer-simple.php
 * customizer framework with css applier
 */
function nadege_customize_items( $settings ) {

	/* Settings for Site Identity Options start here */
	/* ------------------------------------- */
	$settings[] = array(
		'default'			=> '',
		'sanitize_callback' => 'nadege_sanitize_image',
		'id'				=> 'secondary_logo',
		'label'				=> esc_html__('Secondary logo', 'nadege'),
		'description'		=> esc_html__('Recommended 60px x 60px. If provided, the logo will shown on sticky header.', 'nadege'),
		'type'				=> 'image',
		'section'			=> 'title_tagline',
		'priority'			=> 40,
	);	


	/* Settings for Posts Options start here */
	/* ------------------------------------- */

	// Setting : Homepage blog posts list
	$settings[] = array(
		'default'			=> 'classic',
		'sanitize_callback' => 'nadege_sanitize_blog_list_view',
		'id'				=> 'blog_list_view',
		'label'				=> esc_html__('Blog posts list shown as', 'nadege'),
		'type'				=> 'radio',
		'choices'			=> array ( 
			'classic'	=> esc_html__( 'Classic View (Full Posts)', 'nadege' ),
			'list'		=> esc_html__( 'List View', 'nadege' ),
			'grid'		=> esc_html__( 'Grid View', 'nadege' )
		 ),
		'section'			=> 'posts_options'
	);	

	// Setting : Archive page blog posts list
	$settings[] = array(
		'default'			=> 'list',
		'sanitize_callback' => 'nadege_sanitize_blog_list_view',
		'id'				=> 'archive_blog_list_view',
		'label'				=> esc_html__('Archive page posts list shown as', 'nadege'),
		'type'				=> 'radio',
		'choices'			=> array ( 
			'classic'	=> esc_html__( 'Classic View (Full Posts)', 'nadege' ),
			'list'		=> esc_html__( 'List View', 'nadege' ),
			'grid'		=> esc_html__( 'Grid View', 'nadege' )
		 ),
		'section'			=> 'posts_options'
	);	

	// Setting : Archive page blog posts list
	$settings[] = array(
		'default'			=> 'list',
		'sanitize_callback' => 'nadege_sanitize_blog_list_view',
		'id'				=> 'search_blog_list_view',
		'label'				=> esc_html__('Search result page posts list shown as', 'nadege'),
		'type'				=> 'radio',
		'choices'			=> array ( 
			'classic'	=> esc_html__( 'Classic View (Full Posts)', 'nadege' ),
			'list'		=> esc_html__( 'List View', 'nadege' ),
			'grid'		=> esc_html__( 'Grid View', 'nadege' )
		 ),
		'section'			=> 'posts_options'
	);	

	// Setting : Secondary sidebar (the one in homepage) sticky?
	$settings[] = array(
		'default'			=> false,
		'sanitize_callback' => 'nadege_sanitize_checkbox',
		'id'				=> 'pagination_load_more',
		'label'				=> esc_html__('Using ajax load more button instead of default pagination', 'nadege'),
		'type'				=> 'checkbox',
		'section'			=> 'posts_options'
	);

	/* Settings for Footer Options start here */
	/* ------------------------------------- */

	// Setting : Footer Credit
	$settings[] = array(
		'default'			=> nadege_footer_credit(),
		'sanitize_callback' => 'nadege_sanitize_footer_credit',
		'id'				=> 'footer_credit',
		'label'				=> esc_html__('Credit Text', 'nadege'),
		'type'				=> 'textarea',
		'transport'			=> 'postMessage',
		'section'			=> 'footer_options'
	);	

	/* Settings for Colors start here */
	/* ------------------------------------- */

	// Setting : Color Schemes
	$settings[] = array(
		'default'			=> 'default',
		'sanitize_callback' => 'sanitize_text_field',
		'id'				=> 'color_scheme',
		'label'				=> esc_html__('Color Scheme', 'nadege'),
		'type'				=> 'select',
		'choices'			=> nadege_color_schemes_control( nadege_color_schemes() ),
		'transport'			=> 'postMessage',
		'section'			=> 'colors'
	);

	// Setting : Content background color 
	$settings[] = array(
		'default'			=> '#ffffff',
		'sanitize_callback' => 'nadege_sanitize_color_field',
		'id'				=> 'content_background_color',
		'label'				=> esc_html__('Content Box Background Color', 'nadege'),
		'type'				=> 'color',
		'transport'			=> 'postMessage',
		'section'			=> 'colors',
		'apply_css'			=> array (
			array (
				'selector' => '.site, .sticky-menu .site-header, .flex-direction-nav li a, .site-search .search-toggle.toggled + .search-form, .main-navigation ul ul li',
				'property' => 'background-color',
			),
			array (
				'selector' => 
					  'mark, '
					. 'ins, '
					. 'button, '
					. 'button[disabled]:hover, '
					. 'button[disabled]:focus, '
					. 'input[type="button"], '
					. 'input[type="button"][disabled]:hover, '
					. 'input[type="button"][disabled]:focus, '
					. 'input[type="reset"], '
					. 'input[type="reset"][disabled]:hover, '
					. 'input[type="reset"][disabled]:focus, '
					. 'input[type="submit"], '
					. 'input[type="submit"][disabled]:hover, '
					. 'input[type="submit"][disabled]:focus, '
					. '.load-more a, '
					. '.load-more a:hover, '
					. '.load-more a:focus, '
					. '.widget_calendar tbody a, '
					. '.widget_calendar tbody a:hover, '
					. '.widget_calendar tbody a:focus, '
					. '.tagcloud a, '
					. '.page-links a, '
					. '.page-links a:hover, '
					. '.page-links a:focus ',
				'property' => 'color'
			),
			array(
				'selector' => 
					 '.format-quote .entry-meta > .entry-format a svg, '
					. '.format-link .entry-meta > .entry-format a svg ',
				'property' => 'fill'
			),
			array (
				'selector' =>
					  '.main-navigation ul ul:after ',
				'property' => 'border-bottom-color'
			),
			array (
				'selector' =>
					  '.main-navigation ul ul:before ',
				'property' => 'border-bottom-color'
			)
		)
	);

	// Setting : Content text color 
	$settings[] = array(
		'default'			=> '#111111',
		'sanitize_callback' => 'nadege_sanitize_color_field',
		'id'				=> 'text_color',
		'label'				=> esc_html__('Text Color', 'nadege'),
		'type'				=> 'color',
		'transport'			=> 'postMessage',
		'section'			=> 'colors',
		'apply_css'			=> array (
			array (
				'selector' =>
					  'body, '
					. 'blockquote cite, '
					. 'blockquote small, '
					. '.site-branding .site-title a, '
					. '.menu-toggle, '
					. '.dropdown-toggle, '
					. '.search-form  .search-submit, '
					. '.widget-title a, '
					. '.entry-title a, '
					. '.format-link .entry-content > p:first-child > a:first-child, '
					. '.page-links > .page-links-title, '
					. '.main-navigation a, '
					. '.post-navigation a, '
					. '.footer-navigation a, '
					. '.pagination a:hover, ' 
					. '.pagination a:focus, '
					. '.sharedaddy ul li a, '
					. '.sharedaddy ul li a:hover, '
					. '.sharedaddy ul li a:focus, '
					. '.entry-meta .byline, .entry-meta .byline a, '
					. '.widget-recent-posts .tab-control a.active-tab-control, '
					. '.comment-author, '
					. '.comment-reply-title small a:hover, '
					. '.comment-reply-title small a:focus, '
					. '.search-toggle, .search-toggle:hover, .search-toggle:active, .search-toggle:focus ',
				'property' => 'color',
			),
			array (
				'selector' =>
					  'blockquote, '
					. '.menu-toggle.toggled-on, '
					. '.menu-toggle.toggled-on:hover, '
					. '.menu-toggle.toggled-on:focus, '
					. '.widget, '
					. '.page-header, '
					. '.page-links a ',
				'property' => 'border-color'
			),
			array (
				'selector' =>
					  'button:hover, '
					. 'button:focus, '
					. 'input[type="button"]:hover, '
					. 'input[type="button"]:focus, '
					. 'input[type="reset"]:hover, '
					. 'input[type="reset"]:focus, '
					. 'input[type="submit"]:hover, '
					. 'input[type="submit"]:focus, '
					. '.menu-toggle.toggled-on, '
					. '.menu-toggle.toggled-on:hover, '
					. '.menu-toggle.toggled-on:focus, '
					. '.site-featured-posts .featured-background, '
					. '.featured-slider article .post-thumbnail, '
					. '.load-more a:hover, '
					. '.load-more a:focus, '
					. '.tagcloud a:hover, '
					. '.tagcloud a:focus, '
					. '.page-links a ',
				'property' => 'background-color'
			),
			array (
				'selector' => 
					  'fieldset, '
					. 'pre, '
					. 'code, '
					. 'abbr, '
					. 'acronym, '
					. 'table, '
					. 'th, '
					. 'td, '
					. 'input[type="date"], '
					. 'input[type="time"], '
					. 'input[type="datetime-local"], '
					. 'input[type="week"], '
					. 'input[type="month"], '
					. 'input[type="text"], '
					. 'input[type="email"], '
					. 'input[type="url"], '
					. 'input[type="password"], '
					. 'input[type="search"], '
					. 'input[type="tel"], '
					. 'input[type="number"], '
					. 'textarea, '
					. '.site-header, '
					. '.sticky-menu .site-header, '
					. '.main-navigation li, '
					. '.main-navigation .primary-menu, '
					. '.dropdown-toggle:after, '
					. '.social-navigation li, '
					. '.post-navigation, '
					. '.post-navigation .nav-links div + div, '
					. '.image-navigation, '
					. '.comment-navigation, '
					. '.footer-navigation li, '
					. '.site-breadcrumbs, '
					. '.sidebar, '
					. '.widget, '
					. '.tagcloud a, '
					. '.site-content, '
					. '.menu-toggle, '
					. '.header-widget, '
					. '.site-main > article, '
					. '.entry-content, '
					. '.entry-summary, '
					. '.author-info, '
					. '.page-header, '
					. '.site-main.grid-view > article:last-child, '
					. '.pagination, '
					. '.pagination .next, '
					. '.pagination .prev, '
					. '.page-links a, '
					. '.page-links > span, '
					. '.comments-area, '
					. '.comment-list article, '
					. '.comment-list .pingback, '
					. '.comment-list .trackback, '
					. '.comment-list ~ .comment-respond, '
					. '.comment-reply-link, '
					. '.no-comments, '
					. '.not-found .search-form, '
					. '.site-footer, '
					. '.footer-widgets-container, '
					. '.footer-widgets-container .widget-area-full .widget:last-child, '
					. '.widecolumn .mu_register .mu_alert, '
					. '.post-navigation .nav-links div + div:after, '
					. '.classic-view .site-main > article .entry-header, '
					. '.single .site-main > article .entry-header, '
					. '.grid-view > article:nth-child(odd), '
					. '.grid-view .page-header ~ article:nth-child(even), '
					. '.footer-widgets-container .widget-area, '
					. '.widget-area-full .widget-recent-posts ul li, '
					. '.site-header-menu, '
					. '.header-widget .widget, '
					. '.widget_recent_entries li, '
					. '.widget_recent_comments li, '
					. '.main-navigation ul ul, '
					. '.main-navigation ul ul li, '
					. '.widget_archive li a:after, '
					. '.widget_nav_menu li a:after, '
					. '.widget_pages li a:after, '
					. '.widget_meta li a:after, '
					. '.widget_categories li a:after, '
					. '.sidebar, '
					. '.widget-area-full .widget-recent-posts ul li:nth-child(2n) ',
				'property' => 'border-color',
				'color_alpha' => 0.2	
			),
			array (
				'selector' => 
					  '.main-navigation ul ul:before ',
				'property' => 'border-bottom-color',
				'color_alpha' => 0.2
			),
			array (
				'selector' => 
					  '.post-password-form label, '
					. '.social-navigation a, '
					. '.post-navigation .meta-nav, '
					. '.image-navigation, '
					. '.comment-navigation, '
					. '.site-breadcrumbs, '
					. '.site-breadcrumbs a, '
					. '.site-breadcrumbs span:last-child, '
					. 'body:not(.search-results) .entry-summary, '
					. '.widget_recent_entries .post-date, '
					. '.widget_rss .rss-date, '
					. '.widget_rss cite, '
					. '.widget-recent-posts .image-medium.sort-comment_count li .post-thumbnail:before, '
					. '.site-description, '
					. '.entry-meta, '
					. '.entry-meta a, '
					. '.sticky-post, '
					. '.page-header .archive-title-pre, '
					. '.entry-caption, '
					. '.comment-metadata, '
					. '.pingback .edit-link, '
					. '.comment-metadata a, '
					. '.pingback .comment-edit-link, '
					. '.comment-reply-link, '
					. '.comment-form label, '
					. '.form-allowed-tags, '
					. '.wp-caption .wp-caption-text, '
					. '.gallery-caption, '
					. '.widecolumn label, '
					. '.widecolumn .mu_register label, '
					. '.site-info, '
					. '.site-info a ',
				'property' => 'color',
				'color_alpha' => 0.6
			),
			array (
				'selector' =>
					  'input[type="date"]:focus, '
					. 'input[type="time"]:focus, '
					. 'input[type="datetime-local"]:focus, '
					. 'input[type="week"]:focus, '
					. 'input[type="month"]:focus, '
					. 'input[type="text"]:focus, '
					. 'input[type="email"]:focus, '
					. 'input[type="url"]:focus, '
					. 'input[type="password"]:focus, '
					. 'input[type="search"]:focus, '
					. 'input[type="tel"]:focus, '
					. 'input[type="number"]:focus, '
					. 'textarea:focus ',
				'property' => 'border-color',
				'color_alpha' => 0.6
			),
			array (
				'selector' =>
					  '.widget_calendar tbody a:hover,'
					. '.widget_calendar tbody a:focus,'
					. '.format-quote .entry-meta > .entry-format a, '
					. '.format-link .entry-meta > .entry-format a ',
				'property' => 'background-color',
				'color_alpha' => 0.6
			),
			array (
				'selector' =>
					  '.site-search, '
					. '.widget',
				'property' => 'background-color',
				'color_alpha' => 0.04
			),
		)
	);

	// Setting : Link color 
	$settings[] = array(
		'default'			=> '#c06464',
		'sanitize_callback' => 'nadege_sanitize_color_field',
		'id'				=> 'link_color',
		'label'				=> esc_html__('Link Color', 'nadege'),
		'type'				=> 'color',
		'transport'			=> 'postMessage',
		'section'			=> 'colors',
		'apply_css'			=> array (
			array (
				'selector' => 
					  'a, '
					. '.widget .search-form  .search-submit:hover, '
					. '.widget .search-form  .search-submit:focus, '
					. '.main-navigation a:hover, '
					. '.main-navigation a:focus, '
					. '.dropdown-toggle:hover, '
					. '.dropdown-toggle:focus, '
					. '.post-navigation a:hover .post-title, '
					. '.post-navigation a:focus .post-title, '
					. '.footer-navigation a:hover, '
					. '.footer-navigation a:focus, '
					. '.tagcloud a:hover, '
					. '.tagcloud a:focus, '
					. '.widget-twitter .twitter-account a:hover, '
					. '.widget-twitter .twitter-account a:focus, '
					. '.widget-instagram .instagram-account a:hover, '
					. '.widget-instagram .instagram-account a:focus, '
					. '.author-info .author-link:hover, '
					. '.author-info .author-link:focus, '
					. '.site-branding .site-title a:hover, '
					. '.site-branding .site-title a:focus, '
					. '.menu-toggle:hover, '
					. '.menu-toggle:focus, '
					. '.entry-title a:hover, '
					. '.entry-title a:focus, '
					. '.entry-meta a:hover, '
					. '.entry-meta a:focus, '
					. '.more-link:hover .read-more, '
					. '.more-link:focus .read-more, '
					. '.format-link .entry-content > p:first-child > a:first-child:hover, '
					. '.format-link .entry-content > p:first-child > a:first-child:focus, '
					. '.comment-metadata a:hover, '
					. '.comment-metadata a:focus, '
					. '.pingback .comment-edit-link:hover, '
					. '.pingback .comment-edit-link:focus, '
					. '.comment-reply-link, '
					. '.comment-reply-link:hover, '
					. '.comment-reply-link:focus, '
					. '.site-info a:hover, '
					. '.site-info a:focus, '
					. '.main-navigation li:hover > a, '
					. '.main-navigation li.focus > a ',
				'property' => 'color',
			),
			array (
				'selector' => 
					  'mark, '
					. 'ins, '
					. 'button, '
					. 'button:hover, '
					. 'button:focus, '
					. 'input[type="button"]:hover, '
					. 'input[type="button"]:focus, '
					. 'input[type="reset"]:hover, '
					. 'input[type="reset"]:focus, '
					. 'input[type="submit"]:hover, '
					. 'input[type="submit"]:focus, '
					. '.load-more a, '
					. '.tagcloud a, '
					. '.widget_calendar tbody a, '
					. '.page-links a:hover, '
					. '.page-links a:focus ',
				'property' => 'background-color'
			),
			array(
				'selector' =>
					  '.tagcloud a:hover, '
					. '.tagcloud a:focus, '
					. '.menu-toggle:hover, '
					. '.menu-toggle:focus ',
				'property' => 'border-color'  	
			)
		)
	);

	return $settings;

}
add_filter('nadege_customizer_wrapper_settings', 'nadege_customize_items' );
add_filter('nadege_apply_customizer_css', 'nadege_customize_items' );

function nadege_color_schemes_control( $schemes ) {
	$schemes_control = array();
	foreach ( $schemes as $scheme ) {
		$schemes_control[json_encode( $scheme['colors'] )] = $scheme['label'];
	}
	return $schemes_control;
}

function nadege_color_schemes() {
	$schemes = array (
		array (
			'label' => esc_html__( 'Default', 'nadege' ),
			'colors' => array (
				'content_background_color'	=> '#ffffff',
				'text_color'				=> '#111111',
				'link_color'				=> '#c06464',
			),
		),
		array ( 
			'label' => esc_html__( 'Dark', 'nadege' ),
			'colors' => array ( 
				'content_background_color'	=> '#000000',
				'text_color'				=> '#ffffff',
				'link_color'				=> '#9adffd',
			),
		),
		array ( 
			'label' => esc_html__( 'Gray', 'nadege' ),
			'colors' => array (
				'content_background_color'	=> '#616a73',
				'text_color'				=> '#c7c7c7',
				'link_color'				=> '#4d545c',
			),
		),
		array ( 
			'label' => esc_html__( 'Light Brown', 'nadege' ),
			'colors' => array (
				'content_background_color'	=> '#ffef8e',
				'text_color'				=> '#3b3721',
				'link_color'				=> '#eede7d',
			),
		),
		array ( 
			'label' => esc_html__( 'Brown', 'nadege' ),
			'colors' => array (
				'content_background_color'	=> '#3b3721',
				'text_color'				=> '#ffef8e',
				'link_color'				=> '#827347',
			),
		),
	);

	return $schemes;
}


function nadege_partial_refresh_settings( $wp_customize ) {

	if ( ! isset( $wp_customize->selective_refresh ) ) return;

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'container_inclusive' => false,
		'render_callback' => 'nadege_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'container_inclusive' => false,
		'render_callback' => 'nadege_customize_partial_blogdescription',
	) );

	$wp_customize->selective_refresh->add_partial( 'footer_credit', array(
		'selector' => '.site-info',
		'container_inclusive' => false,
		'render_callback' => 'nadege_customize_partial_footer_credit',
	) );

}
add_action( 'nadege_after_customize_wrapper', 'nadege_partial_refresh_settings' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Nadege 1.0
 * @see nadege_customize_register()
 *
 * @return void
 */
function nadege_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Nadege 1.0
 * @see nadege_customize_register()
 *
 * @return void
 */
function nadege_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Nadege 1.0
 * @see nadege_customize_register()
 *
 * @return void
 */
function nadege_customize_partial_footer_credit() {
	nadege_footer_credit(true);
}

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Nadege 1.0
 *
 * @see nadege_header_style()
 */
function nadege_custom_header_and_background() {
	/*$color_scheme             = nadege_get_color_scheme();
	$default_background_color = trim( $color_scheme[0], '#' );
	$default_text_color       = trim( $color_scheme[3], '#' );
*/
	/**
	 * Filter the arguments used when adding 'custom-background' support in Nadege.
	 *
	 * @since Nadege 1.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'nadege_custom_background_args', array(
		'default-color'		=> '#ffffff',
		'wp-head-callback'	=> 'nadege_background_style',
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in Nadege.
	 *
	 * @since Nadege 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-text-color Default color of the header text.
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'nadege_custom_header_args', array(
		'width'                  => 1200,
		'height'                 => 280,
		'flex-height'            => true,
		'wp-head-callback'       => 'nadege_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'nadege_custom_header_and_background' );

if ( ! function_exists( 'nadege_header_style' ) ) :
/**
 * Styles the header text displayed on the site.
 *
 * Create your own nadege_header_style() function to override in a child theme.
 *
 * @since Nadege 1.0
 *
 * @see nadege_custom_header_and_background().
 */
function nadege_header_style() {
	// If the header text option is untouched, let's bail.
	if ( display_header_text() ) {
		return;
	}

	// If the header text has been hidden.
	?>
	<style type="text/css" id="nadege-header-css">
		/*.site-branding {
			margin: 0 auto 40px 0;
		}*/

		.site-branding .site-title,
		.site-description {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	</style>
	<?php
}
endif; // nadege_header_style

if ( ! function_exists( 'nadege_background_style' ) ) :
/**
 * Styles the background image on the site.
 *
 * Create your own nadege_background_style() function to override in a child theme.
 *
 * @since Nadege 0.1.0
 *
 * @see nadege_custom_header_and_background().
 */
function nadege_background_style() {
	$background = get_background_image();

	$style = '';
 
	if ( $background ) {
		$image = " background-image: url('$background');";
 
		$repeat = get_theme_mod( 'background_repeat', 'repeat' );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";
 
		$position = get_theme_mod( 'background_position_x', 'left' );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";
 
		$attachment = get_theme_mod( 'background_attachment', 'scroll' );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";
 
		$style .= $image . $repeat . $position . $attachment;
	}
?>
<style type="text/css">
	body.custom-background { <?php echo esc_attr( trim( $style ) ); ?> }
</style>
<?php
}
endif; // nadege_background_style
