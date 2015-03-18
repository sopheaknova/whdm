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
/**
 * ----------------------------------------------------------------------------------------
 * Email Notification
 * ----------------------------------------------------------------------------------------
 */

add_action( 'wp', 'wi_create_send_email_schedule' );
add_action( 'wi_create_send_email', 'wi_create_email');
add_filter( 'cron_schedules', 'wi_add_minute_schedule' ); 

function wi_create_send_email_schedule(){
	$timestamp = wp_next_scheduled( 'wi_create_send_email');
	
	if( $timestamp == false ){
		wp_schedule_event( time(), 'one_minute', 'wi_create_send_email');
	}
}

function wi_create_email(){
	global $post;
	$reminder = 2592000; // 90 days = 7776000;
	$args = array(
			'post_type'			=> 'sp_order',
			'posts_per_page'	=>	-1,
			'order'				=> 	'ASC',
			'meta_query' => array(
								array(
									'key'     => 'sp_order_expire_date_h',
									'value'   => date('Y-m-d h:i', time() + $reminder ),
									'type'	  => 'datetime',
									'compare' => '<=',
								),
							),
			
		);
	$custom_query = new WP_Query( $args );
	if( $custom_query->have_posts() ) :
		while ( $custom_query->have_posts() ) : $custom_query->the_post();
			$date_expire  = get_post_meta( $post->ID, 'sp_order_expire_date_h', true );
			$client_name  = get_post_meta( $post->ID, 'sp_client_contact_name', true );
			$client_email = sp_get_email_client( get_post_meta( $post->ID, 'sp_order_client_name', true ) );

					$to = $client_email;
					$subject = 'Website Renewal Notice';
					$message = 'Dear' . $client_name . ',' . '<br>' . 
							   'Your domain names' . $client_name . 'that renew manually will expire on' . $date_expire . '. So please do reply to confirm to renew' . '<br>' .
							   'Kindly Regards,' . '<br>' .
							   'NOVA (cambodia) Co., Ltd' . '<br>' .
							   'P. +855 090 223 677' . '<br>' .
							   'E. sokheng.lay@novacambodia.com';
					wp_mail( $to, $subject, $message );

		endwhile; wp_reset_postdata();
	?>
	<?php else : ?>
		<h5>There are no product order will expire.</h5>
	<?php	
	endif; 
}

function wi_add_minute_schedule( $schedules ) {
  $schedules['one_minute'] = array(
    'interval' => 60, // 60 seconds
    'display' => __( 'Every one minute', 'my-plugin-domain' )
  );
  return $schedules;
}

function sp_get_email_client( $post_id ) {
	global $post;
	$client = get_post_meta( $post_id, 'sp_client_email', true );
	
	return $client;
}
