<?php
/**
 * Plugin Name: ICN 2017
 * Description: This plugin is handcrafted for the Ethical MedTech Website 2017. It will add custom post types, custom roles and custom capabilities. Works with Custom Fields plugin
 * Version: 1
 * Author: James Ilaki
 * Author URI: http://www.acw.uk.com/
 **/

function custom_post_types()
{
    /*
     * Case Studies
     */
    $case_studies_labels = [
        'name' => _x('Case Studies', 'plugin', 'icn'),
        'singular_name' => _x('Case Study', 'plugin', 'icn'),
        'all_items' => _x('All Case Studies', 'plugin', 'icn'),
        'add_new' => _x('Add New', 'plugin', 'icn'),
        'add_new_item' => _x('Add New Case Study', 'plugin', 'icn'),
        'edit_item' => _x('Edit Case Study', 'plugin', 'icn'),
        'new_item' => _x('New Case Study', 'plugin', 'icn'),
        'view_item' => _x('View Case Study', 'plugin', 'icn'),
        'search_items' => _x('Search Case Studies', 'plugin', 'icn'),
        'not_found' => _x('No Case Study found', 'plugin', 'icn'),
        'not_found_in_trash' => _x('No Case Study found in Trash', 'plugin', 'icn'),
        'parent_item_colon' => _x('Parent Case Study:', 'plugin', 'icn'),
        'menu_name' => _x('Case Studies', 'plugin', 'icn'),
    ];

    $case_studies_args = [
        'labels' => $case_studies_labels,
        'public' => true,
        'show_in_menus'  => true,
        'show_in_nav_menus'  => true,
        'has_archive' => false,
        'rewrite' => ['slug' => 'case-study'],
        'menu_position' => 19,
        'menu_icon' => 'dashicons-format-aside',
        'capability_type' => "post",
        //'taxonomies'    => array('category'),
        'supports' => ['title', 'editor', 'thumbnail', 'author'],
    ];

    register_post_type('case_studies', $case_studies_args);


    /*
     *  Goals
     */
    $goals_labels = [
        'name' => _x('Goals', 'plugin', 'icn'),
        'singular_name' => _x('Goals', 'plugin', 'icn'),
        'all_items' => _x('All Goals', 'plugin', 'icn'),
        'add_new' => _x('Add New', 'plugin', 'icn'),
        'add_new_item' => _x('Add New Goal', 'plugin', 'icn'),
        'edit_item' => _x('Edit Goals', 'plugin', 'icn'),
        'new_item' => _x('New Goals', 'plugin', 'icn'),
        'view_item' => _x('View Goals', 'plugin', 'icn'),
        'search_items' => _x('Search Goals', 'plugin', 'icn'),
        'not_found' => _x('No Goals found', 'plugin', 'icn'),
        'not_found_in_trash' => _x('No Goals found in Trash', 'plugin', 'icn'),
        'parent_item_colon' => _x('Parent Goals:', 'plugin', 'icn'),
        'menu_name' => _x('Goals', 'plugin', 'icn'),
    ];

    $goals_args = [
        'labels' => $goals_labels,
        'public' => true,
        'show_in_menus'  => true,
        'show_in_nav_menus'  => true,
        'has_archive' => false,
        'rewrite' => ['slug' => 'goal-post'],
        'menu_position' => 10,
        'menu_icon' => 'dashicons-star-filled',
        'capability_type' => "post",
        //'taxonomies'    => array('category'),
        'supports' => ['title', 'editor', 'thumbnail', 'author', 'page-attributes'],
    ];

    register_post_type('goals', $goals_args);

}

add_action( 'init', 'custom_post_types', 900);

/**
 * Custom Roles
 */
function custom_roles()
{
	/*
	 * Add ICN Admin Role
	 */
	$capabilities = [
		'read' => true,
		'edit_posts' => true,
		'delete_posts' => true,
		'publish_posts' => true,
		'upload_files' => true,
	];

	add_role('icn_admin', 'ICN Admin', $capabilities);


    /*
     * Add ICN contributor Role
     */
    $contributor_capabilities = [
        'read' => true,
        'edit_posts' => true,
        'upload_files' => true,
    ];

    add_role('icn_contributor', 'ICN Contributor', $contributor_capabilities);


	/*
	 * Remove the inbuilt roles that won't be used
	 */
	remove_role('subscriber');
	remove_role('author');
	remove_role('contributor');
	remove_role('editor');

}

add_action('init', 'custom_roles', 999);

/**
 * Custom Capabilities
 */
function add_admin_capabilities()
{

	$roles = [
		'administrator'
	];

	foreach ($roles as $the_role) {
		$role = get_role($the_role);

        $role->add_cap('read_icn_posts');
        $role->add_cap('read_private_icn_posts');
        $role->add_cap('edit_icn_posts');
        $role->add_cap('edit_others_icn_posts');
        $role->add_cap('edit_private_icn_posts');
        $role->add_cap('publish_icn_posts');
        $role->add_cap('delete_icn_posts');
        $role->add_cap('delete_others_icn_posts');
        $role->add_cap('delete_private_icn_posts');
        $role->add_cap('delete_published_icn_posts');


	}

	$roles = [
		'icn_admin'
	];

	foreach ($roles as $val) {
		$role = get_role($val);

		$role->add_cap('read');
		$role->add_cap('read_private_pages');
		$role->add_cap('edit_pages');
		$role->add_cap('edit_others_pages');
		$role->add_cap('edit_published_pages');
		$role->add_cap('publish_pages');
		$role->add_cap('delete_pages'); //Ok allow them to delete pages
		$role->add_cap('delete_private_pages'); //Ok allow them to delete private pages
		$role->add_cap('delete_published_pages'); //Ok allow them to delete published pages
		$role->add_cap('delete_others_pages'); //Ok allow them to delete other people's pages


        $role->add_cap('read_icn_posts');
        $role->add_cap('read_private_icn_posts');
        $role->add_cap('edit_icn_posts');
        $role->add_cap('edit_others_icn_posts');
        $role->add_cap('edit_private_icn_posts');
        $role->add_cap('edit_published_icn_posts');
        $role->add_cap('publish_icn_posts');
        $role->add_cap('delete_icn_posts');
        $role->add_cap('delete_others_icn_posts');
        $role->add_cap('delete_private_icn_posts');
        $role->add_cap('delete_published_icn_posts');


        $role->add_cap('edit_users');
		$role->add_cap('list_users');
		$role->add_cap('promote_users');
		$role->add_cap('create_users');
		$role->add_cap('add_users');
		$role->add_cap('delete_users');

		/**
		 * For Media
		 */
		$role->add_cap('edit_others_posts');
		$role->add_cap('delete_others_posts');

        /**
         * WPML
         */
        $role->add_cap('wpml_manage_string_translation');
	}

    $roles = [
        'icn_contributor'
    ];

    foreach ($roles as $val) {

        $role = get_role($val);

        $role->add_cap('read_icn_posts');
        $role->add_cap('edit_icn_posts');
    }

}

add_action('init', 'add_admin_capabilities', 999);


/**
 * Now handle all the housekeeping on Activation
 */
function do_housekeeping() {
	flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'do_housekeeping');

/*
 * Now reverse the housekeeping on Deactivation
 */
function undo_housekeeping() {
	$roles = ['administrator', 'icn_admin', 'icn_contributor'];

	foreach( $roles as $val ) {
		$role = get_role($val);
		foreach ($role->capabilities as $cap => $bool) {
			if (0 === strpos($cap, 'icn_'))
				$role->remove_cap($cap);
		}
	}

    $custom_roles = ['icn_admin', 'icn_contributor'];


	flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'undo_housekeeping');


include_once (__DIR__.'/icn-custom-taxonomies.php');
include_once (__DIR__.'/icn-custom-columns.php');
include_once (__DIR__.'/icn-backend-appearance.php');
include_once (__DIR__.'/icn-user-capabilities.php');
include_once (__DIR__.'/icn-miscellaneous-functions.php');
include_once (__DIR__.'/icn-shortcodes.php');