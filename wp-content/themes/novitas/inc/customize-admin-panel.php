<?php

/**
* Show Admin Bar
*/
show_admin_bar( false );

/**
* Register Navigation Menu
*/
function register_custom_menu() {
	register_nav_menus( array( 'primary' => 'Header Navigation' ) );
}
add_action( 'init', 'register_custom_menu' );

/**
* Add Menu To Top
*/
function add_site_menu_to_top() {
	if ( current_user_can( 'manage_options' ) ) {
		global $wp_admin_bar;

		$wp_admin_bar->add_menu( array(
			'id' => 'menus',
			'title' => __( 'Menus', 'novitas' ),
			'href' => admin_url( 'nav-menus.php' )
			) );
	}
}
add_action( 'admin_bar_menu', 'add_site_menu_to_top', 99 );

/**
* Remove Links From Admin Bar
*/
function remove_admin_bar_links() {
	global $wp_admin_bar, $current_user;

	if ( $current_user->ID != 1 ) {
		$wp_admin_bar->remove_menu( 'wp-logo' ); // Remove the WordPress logo
		$wp_admin_bar->remove_menu( 'updates' ); // Remove the updates link
		$wp_admin_bar->remove_menu( 'comments' ); // Remove the comments link
		$wp_admin_bar->remove_menu( 'new-content' ); // Remove the content link
	}
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

/**
* Remove Pages And Subpages Links For Other Users
*/
function remove_pages_and_subpages() {
	global $userdata;

	if ( $userdata->ID != 1 ) {
		remove_menu_page( 'users.php' ); // Users
		remove_menu_page( 'upload.php' ); // Media
		remove_menu_page( 'edit.php?post_type=page' ); // Pages
		remove_menu_page( 'edit-comments.php' ); // Comments
		remove_menu_page( 'themes.php' ); // Appearance
		remove_menu_page( 'plugins.php' ); // Plugins
		remove_menu_page( 'tools.php' ); // Tools
		remove_menu_page( 'options-general.php' ); // Settings
		remove_menu_page( 'aiowpsec' ); // AIOWPS
		remove_menu_page( 'all-in-one-seo-pack/aioseop_class.php' ); // AIOSP
		remove_menu_page( 'sitepress-multilingual-cms/menu/languages.php' ); // WPML
		remove_menu_page( 'branding' ); // Branding
		remove_menu_page( 'cptui_main_menu' ); // CPTUI
		remove_menu_page( 'woocommerce' ); // Woocommerce

		remove_submenu_page( 'index.php', 'update-core.php' ); // WP UPDATES
		remove_submenu_page( 'index.php', 'be-manage-plugins' ); // BOLDER ELEMENTS
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // Remove Edit Tags
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' ); // Remove Edit Category
		remove_submenu_page( 'index.php', 'relevanssi/relevanssi.php' ); // Relevanssi
		remove_submenu_page( 'woocommerce', 'wc-addons' ); // Woocommerce Add-ons
		remove_submenu_page( 'woocommerce', 'wc-settings'); // Woocommerce Settings
		remove_submenu_page( 'woocommerce', 'wc-status' ); // Woocommerce Status
		remove_submenu_page( 'scx_console', 'scx_console-options' ); // Chat
	}
}
add_action( 'admin_menu', 'remove_pages_and_subpages', 999, 0 );

/**
* ACF - Show Admin
*/
function my_acf_show_admin( $show ) {
	global $userdata;

	return $userdata->ID == 1;
}
add_filter( 'acf/settings/show_admin', 'my_acf_show_admin' );

/**
* Remove Emojis
*/
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
* Engineered By Redberry Rocketmen
*/
function redberry_login_logo_url_title() {
	return 'Engineered by Redberry Rocketmen';
}
add_filter( 'login_headertitle', 'redberry_login_logo_url_title' );

/**
* Remove description from comments on the page
*/
add_action( 'admin_footer-edit-tags.php', 'redberry_remove_cat_tag_description' );

function redberry_remove_cat_tag_description() {
	global $current_screen;

	switch( $current_screen->id ) {
		case 'edit-category':
			// WE ARE AT /wp-admin/edit-tags.php?taxonomy=category
			// OR AT /wp-admin/edit-tags.php?action=edit&taxonomy=category&tag_ID=1&post_type=post
			break;
		case 'edit-post_tag':
			// WE ARE AT /wp-admin/edit-tags.php?taxonomy=post_tag
			// OR AT /wp-admin/edit-tags.php?action=edit&taxonomy=post_tag&tag_ID=3&post_type=post
			break;
	}
	?>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$('#tag-description').parent().remove();
			$('#description').closest('.form-field').remove();
		});
	</script>
	<?php
}

/**
* Add Menu And Submenu Pages
*/
// function add_pages_separated_links() {
// 	// Main Page
// 	add_menu_page( 'Main Page', 'Main Page', 'manage_options', 'phd_main_page', 'phd_main_page', 'dashicons-admin-page' );
// 	add_submenu_page( 'phd_main_page', 'Main Page', 'Main Page', 'manage_options', 'phd_main_page_act', 'phd_main_page_act_func' );
// 	remove_submenu_page( 'phd_main_page', 'phd_main_page' );
// }
// add_action( 'admin_menu', 'add_pages_separated_links' );

/**
* Main Page Callback
*/
// function phd_main_page_act_func() {
// 	$page_id = apply_filters( 'wpml_object_id', 101, 'page', true, ICL_LANGUAGE_CODE );
// 	$page_edit_link = admin_url( 'post.php?post=' . $page_id . '&action=edit&lang=' . ICL_LANGUAGE_CODE );

// 	echo '<script>window.location.href = ' . $page_edit_link . '</script>';
// }
