<?php
/**
 * functions.php
 *
 * The theme's functions and definitions.
 */ 
 
/**
 * ----------------------------------------------------------------------------------------
 * Define constants.
 * ----------------------------------------------------------------------------------------
 */
$shortname 		= get_template(); 
$themeData     	= wp_get_theme( $shortname ); //WP 3.4+ only
$themeName 		= str_replace( ' ', '', $themeData->Name );

//Basic constants	
define( 'SP_THEME_NAME', $themeData->Name );
define ('SP_THEME_VERSION', $themeData->Version );
define( 'SP_TEXT_DOMAIN', strtolower($themeName) );

define( 'SP_BASE_DIR', get_template_directory() );
define( 'SP_BASE_URL', get_template_directory_uri() );
define( 'SP_ASSETS', get_template_directory_uri() . '/assets' );
define( 'SP_TEMPLATES', '/templates' );

/**
 * ----------------------------------------------------------------------------------------
 * Load some admin functions: theme option, metabox, custom post type and taxonomy
 * ----------------------------------------------------------------------------------------
 */
load_template( SP_BASE_DIR . '/library/functions/functions-admin.php' ); 
load_template( SP_BASE_DIR . '/library/functions/theme-options.php'); // All theme options settings
load_template( SP_BASE_DIR . '/library/functions/meta-boxes.php'); // All Metabox settings for post, page and custom template
load_template( SP_BASE_DIR . '/library/functions/functions-menu.php'); //Menu setup
load_template( SP_BASE_DIR . '/library/custom-posts/custom-posts.php'); // Register custom post and taxonmies
load_template( SP_BASE_DIR . '/library/widgets/widgets.php'); // Register widgets and related functions
load_template( SP_BASE_DIR . '/library/shortcodes/shortcodes.php');  // Register shortcode
/**
 * ----------------------------------------------------------------------------------------
 * Load all Theme functions
 * ----------------------------------------------------------------------------------------
 */
load_template( SP_BASE_DIR . '/library/functions/functions-ss.php'); //Register style and script
load_template( SP_BASE_DIR . '/library/functions/functions-branding.php'); // Custom logo, favicon and Apple touch icon
load_template( SP_BASE_DIR . '/library/functions/functions-theme.php'); // General functions using within theme
load_template( SP_BASE_DIR . '/library/functions/aq_resizer.php'); // small function to resize post image on fly


/**
 * ----------------------------------------------------------------------------------------
 * Sets up the content width value based on the theme's design and stylesheet.
 * ----------------------------------------------------------------------------------------
 */
if ( ! isset( $content_width ) )
	$content_width = 940;
	
/**
 * ----------------------------------------------------------------------------------------
 * Theme Setup and theme support
 * ----------------------------------------------------------------------------------------
 */

if( !function_exists('sp_theme_setup') ) {
	
	function sp_theme_setup(){
		
		/* Makes theme available for translation. */
		load_theme_textdomain( SP_TEXT_DOMAIN, SP_BASE_DIR . '/languages' );

		/* Add visual editor stylesheet support */
		add_editor_style( SP_ASSETS . '/css/base.css');
	
		/* Adds RSS feed links to <head> for posts and comments. */
		add_theme_support( 'automatic-feed-links' );

		/* Add suport for post thumbnails and set default sizes */
		add_theme_support( 'post-thumbnails' );

		/* Add custom thumbnail sizes: base size 1280x768, 960x576, 940x564, 640x384, 320x192 */
		set_post_thumbnail_size( 320, 192, true );

		/* And HTML5 support */
		add_theme_support( 'html5' );
		
	}
	add_action( 'after_setup_theme', 'sp_theme_setup' );

}

