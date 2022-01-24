<?php

/**
 * Rearrange the menu
 * @param $menu_ord
 * @return array|bool
 */
function custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;
	return array(
		'index.php', // Dashboard
		'separator1',
		'edit.php?post_type=page', // Pages
        'edit.php?post_type=case_studies', // case studies
        'edit.php?post_type=goals', // Goals
		'edit.php', // Posts
		'upload.php', // Media
		'edit-comments.php', // Comments
		'separator-last',
		'wma-options-forms',
		'themes.php', // Appearance
		'plugins.php', // Plugins
		'users.php', // Users
		'profile.php', // Profile
		'tools.php', // Tools
		'options-general.php', // Settings

	);
}

add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
add_filter('menu_order', 'custom_menu_order');

/**
 * Remove some menu items
 */
function custom_menu_page_removing() {
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
	remove_menu_page( 'tools.php' );

}

add_action( 'admin_menu', 'custom_menu_page_removing' );

/**
 * Set default admin color scheme and disable picking of admin color scheme
 * @param $user_id
 */
function set_default_admin_color_scheme($user_id) {
	$args = array(
		'ID' => $user_id,
		'admin_color' => 'default'
	);
	wp_update_user( $args );
}

add_action('user_register', 'set_default_admin_color_scheme');
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );


/**
 * Remove Admin bar
 */
show_admin_bar(false);


/**
 * Add Custom CSS to the Admin Section
 */
function custom_css() {
	echo '<style></style>';
}

add_action('admin_head', 'custom_css');

/**
 * Remove some stuff from the admin top menu
 */
function remove_admin_nodes() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('comments');
}

add_action('wp_before_admin_bar_render', 'remove_admin_nodes', 0);


/**
 * Add some admin toolbar items
 */
function add_admin_nodes() {
	global $wp_admin_bar;
	$args = [
		'id' => 'acw_support',
		'title' => "Email ACW Support",
		'parent' => "my-account",
		'href' => 'mailto:web@acw.uk.com&subject=WMA Support',
	];

	$wp_admin_bar->add_node($args);
}

add_action('wp_before_admin_bar_render', 'add_admin_nodes', 0);


/**
 * Change some admin toolbar items
 */
function change_admin_nodes($wp_admin_bar) {
	function replace_first($find, $replace, $subject) {
		return implode($replace, explode($find, $subject, 2));
	}

	$account = $wp_admin_bar->get_node('my-account');
	$old_salute = $account->title;
	$new_title = str_replace( 'How are you, ', '', $old_salute );
	$new_title = str_replace( 'Howdy, ', '', $new_title );
	$new_title = replace_first('?', '', $new_title);

	$wp_admin_bar->add_node( [
		'id' => 'my-account',
		'title' => $new_title,
	]);

	$wp_admin_bar->add_node( [
		'id' => 'site-name',
		'title' => "<img src='" . get_template_directory_uri() . "/assets/img/ICN_admin_logo.jpg' />",
	]);
}

add_action('admin_bar_menu', 'change_admin_nodes', 999);