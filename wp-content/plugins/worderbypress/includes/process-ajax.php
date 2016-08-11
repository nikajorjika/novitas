<?php

/**
 * Saver post types order
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
function rc_wobp_save_order() {
	
	global $wpdb;
	
	$action             = $_POST['action']; 
	$posts_array        = $_POST['post'];
	$listing_counter 	= 1;
	
	foreach ($posts_array as $post_id) {
		
		$wpdb->update( 
					$wpdb->posts, 
						array('menu_order' 	=> $listing_counter), 
						array('ID'   		=> $post_id) 
					);

		$listing_counter++;
	}
	
	die();
}
add_action('wp_ajax_rc_wobp_update_order', 'rc_wobp_save_order');


/**
 * Save taxonomies and categories order
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
function rc_wobp_save_taxonomies_order() {
	global $wpdb;
	
	$action             = $_POST['action']; 
	$tags_array         = $_POST['tag'];
	$listing_counter 	= 1;
	
	foreach ($tags_array as $tag_id) {
		
		$wpdb->update( 
					$wpdb->terms, 
						array('term_group' 			=> $listing_counter), 
						array('term_id'   	=> $tag_id) 
					);

		$listing_counter++;
	}
	
	die();
}
add_action('wp_ajax_rc_wobp_update_order_taxonomies', 'rc_wobp_save_taxonomies_order');