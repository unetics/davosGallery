<?php
	if ( ! function_exists('gallery_post_type') ) {

// Register Custom Post Type
function gallery_post_type() {

	$labels = array(
		'name'                => 'Gallerys',
		'singular_name'       => 'Gallery',
		'menu_name'           => 'Gallerys',
		'name_admin_bar'      => 'Gallerys',
		'parent_item_colon'   => 'Gallerys',
		'all_items'           => 'All Gallerys',
		'add_new_item'        => 'Add New Gallery',
		'add_new'             => 'Add Gallery',
		'new_item'            => 'New Gallery',
		'edit_item'           => 'Edit Gallery',
		'update_item'         => 'Update Gallery',
		'view_item'           => 'View Gallery',
		'search_items'        => 'Search Gallerys',
		'not_found'           => 'Not found',
		'not_found_in_trash'  => 'Not found in Trash',
	);
	$args = array(
		'label'               => 'ps_gallery',
		'description'         => 'Gallerys',
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-gallery',
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'ps_gallery', $args );

}

// Hook into the 'init' action
add_action( 'init', 'gallery_post_type', 0 );

}