<?php
/**
 * Add a new custom taxonomy for Attachments
 */
function create_media_types_taxonomy() {
	$media_types_labels = [
		'name'                           => 'Media Types',
		'singular_name'                  => 'Media Type',
		'search_items'                   => 'Search Media Types',
		'all_items'                      => 'All Media Types',
		'edit_item'                      => 'Edit Media Type',
		'update_item'                    => 'Update Media Type',
		'add_new_item'                   => 'Add New Media Type',
		'new_item_name'                  => 'New Media Type Name',
		'menu_name'                      => 'Media Types',
		'view_item'                      => 'View Media Type',
		'popular_items'                  => 'Popular Media Types',
		'separate_items_with_commas'     => 'Separate Media Types with commas',
		'add_or_remove_items'            => 'Add or remove Media Types',
		'choose_from_most_used'          => 'Choose from the most used Media Types',
		'not_found'                      => 'No Media Types found'
	];
	$capabilities = [
		'manage_terms' => 'edit_icn_posts',
		'edit_terms'   => 'edit_icn_posts',
		'delete_terms' => 'delete_icn_posts',
		'assign_terms' => 'edit_icn_posts',
	];
	register_taxonomy(
		'media_types',
		['attachment'],
		[
			'label' => __( 'Media Types' ),
			'rewrite' => ['slug' => 'media-types'],
			'hierarchical' => true,
			'labels' => $media_types_labels,
			'capabilities' => $capabilities,
		]
	);
}
add_action( 'init', 'create_media_types_taxonomy' );