<?php
// Path To Theme
$path_to_theme = str_replace('\\', '/', get_template_directory());

// General Helper Functions
require $path_to_theme . '/inc/general-functions.php';

// Cusomize Admin Panel
require $path_to_theme . '/inc/customize-admin-panel.php';

// Styles
require $path_to_theme . '/inc/enqueue-styles.php';

// Scripts
require $path_to_theme . '/inc/enqueue-scripts.php';

// Localized Variables
require $path_to_theme . '/inc/localize-script.php';

// Custom Image Resizer
require $path_to_theme . '/inc/custom-image-resizer.php';

// Change Default Post Type
require $path_to_theme . '/inc/change-default-post-type.php';

// Ajax Forms Handler
require $path_to_theme . '/inc/ajax-forms-handler.php';

// Setup WooCommerce
// require $path_to_theme . '/inc/wc-setup.php';

// Modify Relevanssi
// require $path_to_theme . '/inc/modify-relevanssi.php';

/**
* FIX WPML and WP Compatibility Issue. When post is duplicated (identical slugs) and after that
* the slug is modified, old slug is kept as _wp_old_slug and when accessed post in default language,
* wp sees at as _wp_old_slug and tries to redirect it to the current permalink which is the same
* as _wp_old_slug producing redirect loop
*/
add_filter( 'old_slug_redirect_url', 'old_slug_bug_fix' );

function old_slug_bug_fix( $link ) {
	if ( $link === get_the_permalink() ) {
		return '';
	}

	return $link;
}

/**
* Don't cut images with this sizes
*/
add_filter( 'intermediate_image_sizes_advanced', 'redberry_filter_image_sizes' );

function redberry_filter_image_sizes( $sizes ) {
  // unset( $sizes['thumbnail'] );
  unset( $sizes['medium'] );
  unset( $sizes['large'] );

  return $sizes;
}

/**
* with this we are modifying the wp_title thing (the title tag of pages)
*/
add_filter( 'wp_title', 'website_title', 10, 2 );

function website_title( $title ) {
	return $title . ' | ' . __( 'Redberry', 'novitas' );
}

/**
* Remove Blog post default editor
*/
add_action( 'admin_init', 'remove_box' );

function remove_box() {
	remove_post_type_support( 'post', 'editor' );
}


