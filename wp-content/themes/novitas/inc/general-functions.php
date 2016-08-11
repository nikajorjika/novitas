<?php

/**
 * This file contains general helper functions
 */

/**
 * This function returns image source from image field
 * @param [array|integer] $field_data - ACF field name and post ID | Image ID
 * @param [array] $image_sizes - image width and height
 * @return [string] - empty string or image source
 */
function ka_get_image_src( $field_data, $image_sizes = array() ) {
	$image_src = '';
	// If POST ID is not defined set to `false` to target the current post
	$post_id = ! empty( $field_data[1] ) ? $field_data[1] : false;
	$width = ! empty( $image_sizes[0] ) ? $image_sizes[0] : '9999';
	$height = ! empty( $image_sizes[1] ) ? $image_sizes[1] : '9999';

	if ( is_array( $field_data ) ) {
		$field_name = ! empty( $field_data[0] ) ? $field_data[0] : '';

		if ( ! empty( $field_name ) ) {
			$image = get_field( $field_name, $post_id );

			if ( $image ) {
				$image_id = $image['ID'];
			}
		}
	}
	else {
		$image_id = $field_data;
	}

	if ( isset( $image_id ) && $image_id > 0 ) {
		$dimensions = 'wh' . $width . 'x' . $height;
		$attachment = wp_get_attachment_image_src( $image_id, $dimensions );

		if ( $attachment ) {
			$image_src = esc_url( $attachment[0] );
		}
	}
	return $image_src;
}
function language_selector_custom(){
	$languages = icl_get_languages('skip_missing=0&orderby=code');
	if(!empty($languages)){
		foreach($languages as $l){
			$active = ICL_LANGUAGE_CODE == icl_disp_language($l['language_code'])? "active": '';
			print '<li class="'.$active.'"><a href="'.$l['url'].'">'.strtoupper(icl_disp_language($l['language_code'])).'</a></li>';
		}
	}
}
function pagination()
{
	the_posts_pagination( array(
		'mid_size' => 2,
		'prev_text' => __( '<i class="fa fa-angle-left" aria-hidden="true"></i>', 'hbtech' ),
		'next_text' => __( '<i class="fa fa-angle-right" aria-hidden="true"></i>', 'hbtech' ),
		'screen_reader_text' => '.'
	) );
}
function my_acf_init() {

	acf_update_setting('google_api_key', 'AIzaSyA_MSQT6AnnZaajkR_ZY2_Yw6eYjHXaGmw');
}

add_action('acf/init', 'my_acf_init');