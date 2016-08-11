<?php
/*
Plugin Name: WorderbyPress 
Plugin URL: http://remicorson.com/worderbypress
Description: Allows you to reorder posts, pages, custom post types, taxonomies, tags, custom taxonomies and categories easily.
Version: 1.3
Author: Remi Corson
Author URI: http://remicorson.com
Contributors: corsonr
*/

/*
|--------------------------------------------------------------------------
| MAIN CLASS
|--------------------------------------------------------------------------
*/

class rc_wobp_taxonomies_order_class {

	/**
	 * Constructor
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function __construct() {
		global $pagenow;
		
		// Edit Posts, Pages, and CPTs
		if( $pagenow == 'edit.php') {
			add_action( 'init', array( &$this,'rc_wobp_load_scripts') );
					
		// Categories, Taxonomies
		} elseif( $pagenow == 'edit-tags.php') {
			add_action( 'init', array( &$this,'rc_wobp_load_scripts_taxonomies') );		
			 
		} // end if
		include(dirname(__FILE__) . '/includes/process-ajax.php');
		
		add_filter( 'pre_get_posts', array( &$this,'rc_wobp_reorder_list') );
		add_filter( 'get_terms_orderby', array( &$this,'rc_wobp_reorder_taxonomies_list'), 10, 2 );
		
	}
	
	/**
	 * Allows to reorder posts, pages and custom post types with drag n drop
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function rc_wobp_load_scripts() {
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('rc_wobp-update-order', plugin_dir_url(__FILE__) . 'includes/js/update-order.js');
		wp_enqueue_style('rc_wobp-admin-styles', plugin_dir_url(__FILE__) . 'includes/css/admin.css');
	}
	
	/**
	 * Allows to reorder taxonomies, tags and categories with drag n drop
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function rc_wobp_load_scripts_taxonomies() {
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('rc_wobp-update-order', plugin_dir_url(__FILE__) . 'includes/js/update-order-taxonomies.js');
		wp_enqueue_style('rc_wobp-admin-styles', plugin_dir_url(__FILE__) . 'includes/css/admin.css');
	}

	/**
	 * Reorder elements in default list by menu_order instead of date or ID
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function rc_wobp_reorder_list( $query ) {
	
		if( $query->is_main_query() ) {
			$query->set('orderby', 'menu_order');
			$query->set('order', 'ASC');
		}
		
		return $query;
	}
	
	/**
	 * Reorder elements in default list by menu_order instead of name by default
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function rc_wobp_reorder_taxonomies_list($orderby, $args) {
	
		$orderby = "t.term_group";
		
		return $orderby;

	}
		
}


// instantiate plugin's class
$GLOBALS['rc_wobp_taxonomies_order'] = new rc_wobp_taxonomies_order_class();


