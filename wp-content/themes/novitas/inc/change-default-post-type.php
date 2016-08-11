<?php

/**
* Change Default Post Type
*/
function redberry_change_post_label() {
	global $menu;
	global $submenu;

	$menu[5][0] = 'Blog Posts';
	$submenu['edit.php'][5][0] = 'Blog Posts';
	$submenu['edit.php'][10][0] = 'Add New Blog Post';
	$submenu['edit.php'][15][0] = 'Categories';
	$submenu['edit.php'][16][0] = 'Tags';
	
	if( ! current_user_can( 'manage_options' ) ) {
		remove_menu_page( 'edit.php' );
		remove_menu_page( 'edit-comments.php' );
	}
}
add_action( 'admin_menu', 'redberry_change_post_label' );

function redberry_change_post_object() {
	global $wp_post_types;

	$labels = &$wp_post_types['post']->labels;

	$labels->name = 'Blog Posts';
	$labels->singular_name = 'Blog';
	$labels->add_new = 'Add New Blog Posts';
	$labels->add_new_item = 'Add New Blog Posts';
	$labels->edit_item = 'Edit Blog Posts';
	$labels->new_item = 'Blog Post';
	$labels->view_item = 'View Blog Post';
	$labels->search_items = 'Search Blog Posts';
	$labels->not_found = 'Not Found';
	$labels->not_found_in_trash = 'Trash is Empty';
	$labels->all_items = 'All Blog Posts';
	$labels->menu_name = 'Blog Posts';
	$labels->name_admin_bar = 'Blog Posts';

	$capabilities = &$wp_post_types['post']->cap;

	$capabilities->publish_posts = 'manage_options';
	$capabilities->edit_posts = 'manage_options';
	$capabilities->edit_others_posts = 'manage_options';
	$capabilities->delete_posts = 'manage_options';
	$capabilities->delete_others_posts = 'manage_options';
	$capabilities->read_private_posts = 'manage_options';
	$capabilities->edit_post = 'manage_options';
	$capabilities->delete_post = 'manage_options';
	$capabilities->read_post = 'manage_options';
	$capabilities->delete_private_posts = 'manage_options';
	$capabilities->delete_published_posts = 'manage_options';
	$capabilities->edit_private_postsc = 'manage_options';
	$capabilities->edit_published_posts = 'manage_options';
}
add_action( 'init', 'redberry_change_post_object' );
