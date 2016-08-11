<?php

/**
* Enqueue Scripts
*/
add_action( 'wp_enqueue_scripts', 'redberry_scripts' );

function redberry_scripts() {
	// Path To Theme Directory
	$uri = get_template_directory_uri();
	$template = get_page_template_slug();
	// Defines Scripts Loading Order
	$dependency = array(
		'jquery',
		'context_free_js'
		);
	$script_js_dependency = array(
		'jquery',
		'context_free_js',
		'tabs'
		);

	if ( $template == 'page-contact.php' ) {
//		wp_register_script( 'google_map_js', '//maps.googleapis.com/maps/api/js?sensor=false', array( 'jquery' ), '1' );
//		wp_enqueue_script( 'google_map_js' );
	}

	// Fit-Text JS
	wp_register_script( 'fit_text_js', $uri . '/js/jquery.fit-text.js', array( 'jquery' ), '1' );
	// Flexslider JS
	wp_register_script( 'flexslider_js', $uri . '/js/vendor/jquery.flexslider.js', array( 'jquery' ), '1' );
	// Modernizr JS
	wp_register_script( 'modernizr_js', $uri . '/js/vendor/modernizr.js', array( 'jquery' ), '1' );
	// DotDotDot JS
	wp_register_script( 'dotdotdot_js', $uri . '/js/vendor/jquery.dotdotdot.min.js', array( 'jquery' ), '1' );
	// Fancybox JS
	wp_register_script( 'fancybox_js', $uri . '/js/vendor/jquery.fancybox.pack.js', array( 'jquery' ), '1' );
	// Context-Free Functions JS
	wp_register_script( 'context_free_js', $uri . '/js/context-free.js', array( 'jquery' ), '1' );
	// Related Posts Slider JS
	wp_register_script( 'related_posts_slider_js', $uri . '/js/related-posts-slider.js', $dependency, '1' );
	// All Google Maps JS
//	wp_register_script( 'google_maps_js', $uri . '/js/google-maps.js', array( 'jquery' ), '1' );
	// All AJAX Forms JS
	wp_register_script( 'ajax_forms_js', $uri . '/js/ajax-forms.js', $dependency, '1' );
	//mCustomScrollBar js
	wp_register_script( 'mCustomScrollbar', $uri . '/js/jquery.mCustomScrollbar.concat.min.js', $dependency, '1' );
	//tabs switcher js //author HBtech
	wp_register_script( 'tabs', $uri . '/js/tabs.js', array('jquery'), '1' );
	//Select ajax functionality
	wp_register_script( 'select', $uri . '/js/select.js', array('jquery'), '1' );
	//ajax suggestions javascript
	wp_register_script( 'suggestions', $uri . '/js/ajax-suggestions.js', array('jquery'), '1' );
	//localize vars for ajax calls
	$localized_vars = array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'isAdmin' => is_admin()
	);
	wp_localize_script( 'select', 'localizedVars', $localized_vars );
	// Main JS
	wp_register_script( 'main_js', $uri . '/js/scripts.js', $script_js_dependency, '1' );

	// Fit-Text JS
	wp_enqueue_script( 'fit_text_js' );
	// Flexslider JS
	wp_enqueue_script( 'flexslider_js' );
	// Modernizr JS
	wp_enqueue_script( 'modernizr_js' );
	// DotDotDot JS
	wp_enqueue_script( 'dotdotdot_js' );
	//Fancybox JS
	wp_enqueue_script( 'fancybox_js' );
	// Context-Free Functions JS
	wp_enqueue_script( 'context_free_js' );
	// Related Posts Slider JS
	wp_enqueue_script( 'related_posts_slider_js' );
	// All AJAX Forms JS
//	wp_enqueue_script( 'google_maps_js' );
	// All AJAX Forms JS
	wp_enqueue_script( 'ajax_forms_js' );
	//mCustomScrollbar
	wp_enqueue_script( 'mCustomScrollbar' );
	//include Tabs
	wp_enqueue_script( 'tabs' );
	//enqueue select javascript
	wp_enqueue_script( 'select' );
	//suggestions enqueue
	wp_enqueue_script( 'suggestions' );
	// Main JS
	wp_enqueue_script( 'main_js' );
}

/**
* Enqueue Scripts To Admin Pages
*/
// add_action( 'admin_enqueue_scripts', 'admin_enqueue_redberry_scripts' );

// function admin_enqueue_redberry_scripts( $hook ) {
	// Path To Theme Directory
	// $uri = get_template_directory_uri();

	// Custom JS
	// wp_register_script( 'custom_js', $uri . '/js/scripts.js', array( 'jquery' ), '1' );

	// Custom JS
	// wp_enqueue_script( 'custom_js' );
// }
