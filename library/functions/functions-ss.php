<?php


/**
 * ----------------------------------------------------------------------------------------
 * Register styles and scripts
 * ----------------------------------------------------------------------------------------
 */
if( !function_exists('sp_frontend_scripts_styles') ) {

	function sp_frontend_scripts_styles() {
		
		//Register CSS style
		wp_enqueue_style('gfont-opensans', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700', false, SP_THEME_VERSION);
		wp_enqueue_style('theme-info', SP_BASE_URL . '/style.css', false, SP_THEME_VERSION);
		wp_enqueue_style('fontello', SP_ASSETS . '/css/fontello.css', false, SP_THEME_VERSION);
		wp_enqueue_style('normalize', SP_ASSETS . '/css/normalize.css', false, SP_THEME_VERSION);
		wp_enqueue_style('base', SP_ASSETS . '/css/base.css', false, SP_THEME_VERSION);
		wp_enqueue_style('magnific-popup', SP_ASSETS . '/css/magnific-popup.css', false, SP_THEME_VERSION);
		wp_enqueue_style('magnific-custom', SP_ASSETS . '/css/magnific-custom.css', false, SP_THEME_VERSION);
		wp_enqueue_style('main', SP_ASSETS . '/css/main.css', false, SP_THEME_VERSION);
		
		//Register scripts
		wp_enqueue_script('modernizr', SP_ASSETS . '/js/vendor/custom-modernizr.min.js', array('jquery'), SP_THEME_VERSION, false);
		wp_enqueue_script('magnific-popup', SP_ASSETS . '/js/vendor/jquery.magnific-popup.min.js', array('jquery'), SP_THEME_VERSION, false);
		wp_enqueue_script('main', SP_ASSETS . '/js/main.js', array('jquery'), SP_THEME_VERSION, true);

		if ( is_singular() && comments_open() ) { wp_enqueue_script( 'comment-reply' ); }

		if ( ot_get_option('responsive') != 'off' ) {
			wp_enqueue_style('menu-mobile', SP_ASSETS . '/css/menu-mobile.css', false, SP_THEME_VERSION);
			wp_enqueue_style('responsive', SP_ASSETS . '/css/responsive.css', false, SP_THEME_VERSION);
			wp_enqueue_script('mobile-menu', SP_ASSETS . '/js/mobile-menu.js', array('jquery'), SP_THEME_VERSION, true);
		}
		
	}
	add_action('wp_enqueue_scripts', 'sp_frontend_scripts_styles'); //print Script and CSS
}

/**
 * ----------------------------------------------------------------------------------------
 * Print customs css
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists('sp_print_ie_script') ){

	add_action('wp_head', 'sp_print_ie_script');
	
	function sp_print_ie_script(){
		echo '<!--[if lt IE 9]>'. "\n";
		echo '<script src="' . esc_url( SP_ASSETS . '/js/vendor/html5.js' ) . '"></script>'. "\n";
		echo '<![endif]-->'. "\n";
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Print customs css and script
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists('sp_print_custom_css_script') ){

	add_action('wp_head', 'sp_print_custom_css_script');
	
	function sp_print_custom_css_script(){
?>
	<style type="text/css">
		/* custom style */
	</style>

	<?php if ( is_page() || is_singular() ) : ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		    $('a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"]').each(function(){
	        	if ($(this).parents('.gallery').length == 0) {
		            $(this).magnificPopup({
		               type: 'image',
		               removalDelay: 500,
		               mainClass: 'mfp-fade'
		            });
		        }
		    });
		    $('.entry-content .gallery').each(function() {
		        $(this).magnificPopup({
		            delegate: 'a',
		            type: 'image',
		            removalDelay: 300,
		            mainClass: 'mfp-fade',
		            gallery: {
		            	enabled: true,
		            	navigateByImgClick: true
		            }
		        });
		    });
	    });

	</script>
	<?php endif; ?>
<?php		
	}

}

