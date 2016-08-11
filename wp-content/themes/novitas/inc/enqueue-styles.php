<?php

/**
* Enqueue Styles
*/
add_action( 'wp_enqueue_scripts', 'redberry_styles' );

function redberry_styles() {
	// Path To Theme Directory
	$uri = get_template_directory_uri();

	wp_register_style( 'fa', get_template_directory_uri() . '/css/fa/css/font-awesome.css', array(), '1', false);
	// Default CSS
	wp_register_style( 'style_css', $uri . '/style.css', array(), '1', 'all' );
	//custom scrollbar css
	wp_register_style( 'custom_scroll_bar', $uri . '/css/jquery.mCustomScrollbar.css', array(), '1', 'all' );
	// Reset CSS
	wp_register_style( 'reset_css', $uri . '/css/reset.css', array(), '1', 'all' );
	// Fonts CSS
	wp_register_style( 'fonts_css', $uri . '/css/fonts.css', array(), '1', 'all' );
	// Flexslider CSS
	wp_register_style( 'flexslider_css', $uri . '/css/flexslider.css', array(), '1', 'all' );
	// Fancybox CSS
	wp_register_style( 'fancybox_css', $uri . '/css/jquery.fancybox.css', array(), '1', 'all' );
	// Custom CSS
	wp_register_style( 'custom_css', $uri . '/css/styles.css', array(), '1', 'all' );
	// Custom CSS - Max Width 1450px
	wp_register_style( 'custom_css_1450', $uri . '/css/styles.max-width-1450.css', array(), '1', 'all' );
	// Custom CSS - Max Width 960px
	wp_register_style( 'custom_css_960', $uri . '/css/styles.max-width-960.css', array(), '1', 'all' );
	// Custom CSS - Max Width 600px
	wp_register_style( 'custom_css_600', $uri . '/css/styles.max-width-600.css', array(), '1', 'all' );


	wp_enqueue_style( 'fa');
	// Default CSS
	wp_enqueue_style( 'style_css' );
	//mCustomScrollBar
	wp_enqueue_style( 'custom_scroll_bar' );
	// Reset CSS
	wp_enqueue_style( 'reset_css' );
	// Fonts CSS
	wp_enqueue_style( 'fonts_css' );
	// Flexslider Css
	wp_enqueue_style( 'flexslider_css' );
	// Fancybox CSS
	wp_enqueue_style( 'fancybox_css' );
	// Custom CSS
	wp_enqueue_style( 'custom_css' );
	// Custom CSS - Max Width 1450px
	wp_enqueue_style( 'custom_css_1450' );
	// Custom CSS - Max Width 960px
	wp_enqueue_style( 'custom_css_960' );
	// Custom CSS - Max Width 600px
	wp_enqueue_style( 'custom_css_600' );
}
