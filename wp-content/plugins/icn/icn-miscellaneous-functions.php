<?php

function set_caps() {
	$role = get_role('icn_admin');

	var_dump($role->capabilities);
	exit();
}

//add_filter('admin_init', 'set_caps');

/**
 * Remove Admin bar for non admins
 */

function remove_admin_bar() {
	if ( ! current_user_can('administrator') && ! is_admin()) {
		show_admin_bar(false);
	}
}

add_action('after_setup_theme', 'remove_admin_bar');

if ( ! function_exists( 'icn_images' ) ) {
	function icn_images() {
		add_image_size( 'home-page-slider', 1800, 730, ['center', 'center'] );
		add_image_size( 'big-background', 1800, 530, ['center', 'center'] );
		add_image_size( 'team-photo-thumb', 210, 210, ['left', 'top']);
	}

//    add_action( 'after_setup_theme', 'icn_images' );
}

function icn_svg_mime_type($mimes = []) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'icn_svg_mime_type' );

if ( function_exists('acf_add_options_page') ) {
	acf_add_options_page([
		'page_title' => 'ICN Options',
		'menu_slug' => 'icn-options',
		'capability' => 'edit_icn_posts',
		'parent_slug' => '',
		'autoload' => true,
		'icon_url' => false,
	]);
}

if ( function_exists('acf_add_options_sub_page') ) {
    acf_add_options_sub_page([
        'page_title' 	=> 'ICN CPT Pages',
        'menu_slug' 	=> 'icn-options-cpt-pages',
        'parent_slug'   => 'icn-options',
        'capability'	=> 'edit_icn_posts',
        'autoload'      => true,
        'icon_url'      => false,
    ]);

    acf_add_options_sub_page([
        'page_title' 	=> 'ICN Footer',
        'menu_slug' 	=> 'icn-options-footer',
        'parent_slug'   => 'icn-options',
        'capability'	=> 'edit_icn_posts',
        'autoload'      => true,
        'icon_url'      => false,
    ]);

	acf_add_options_sub_page([
		'page_title' => 'ICN Forms',
		'menu_slug' => 'icn-options-forms',
		'parent_slug' => 'icn-options',
		'capability' => 'edit_icn_posts',
		'autoload' => true,
		'icon_url' => false,
	]);

	acf_add_options_sub_page([
		'page_title' 	=> 'ICN Redirects',
		'menu_slug' 	=> 'icn-redirects',
		'parent_slug'   => 'icn-options',
		'capability'	=> 'edit_icn_posts',
		'autoload'      => true,
		'icon_url'      => false,
	]);
}


/**
 * Define SMTP settings to be used by PHP Mailer
 * @param PHPMailer $phpmailer
 */
function icn_phpmailer_init( PHPMailer $phpmailer ) {
	$phpmailer->Host = 'acw-server1.co.uk';
	$phpmailer->Port = 25;
	$phpmailer->Username = 'newsletterl4@acw-server1.co.uk';
	$phpmailer->Password = '&mailer0209!'; // if required
	$phpmailer->SMTPAuth = true;
	// $phpmailer->SMTPSecure = 'ssl'; // enable if required, 'tls' is another possible value

	$phpmailer->IsSMTP();
}

add_action( 'phpmailer_init', 'icn_phpmailer_init' );


/**
 * Allow ICN Contributors to delete their own media.
 * This method actually just allows them to see only their own media
 * To delete, use the delete_posts capability (and with this, they can only delete what they see - i.e. their own)
 */
function attachments_wp_query_where( $where ){
	global $current_user;

	if( is_user_logged_in() ){
		if( isset( $_POST['action'] ) ){
			// media libary query
			if( $_POST['action'] == 'query-attachments' && in_array('icn_contributor', (array) $current_user->roles) ){
				$where .= ' AND post_author=' . $current_user->data->ID;
			}
		}
	}

	return $where;
}
add_filter( 'posts_where', 'attachments_wp_query_where' );


/**
 * Add left join for including custom fields in searches
 * @param $join
 * @return string
 */
function cf_search_join( $join ) {
	global $wpdb;

	if ( is_search() )
		$join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';

	return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where whilst including custom fields in searches
 * @param $where
 * @return mixed
 */
function cf_search_where( $where ) {
	global $wpdb;

	if ( is_search() ) {
		$where = preg_replace(
			"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
	}

	return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

/**
 * Prevent duplicates whilst including custom fields in searches
 * @param $where
 * @return string
 */
function cf_search_distinct( $where ) {
	global $wpdb;

	if ( is_search() ) {
		return "DISTINCT";
	}

	return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );


/**
 * Define the post types to include in general search
 * @param $query
 * @return mixed
 */
function med_search_post_types( $query ) {

    if ( $query->is_search && ! is_admin() ) {
        $is_general_search = ( array_key_exists('search_type', $_REQUEST) && $_REQUEST['search_type'] );

        if ( $is_general_search ) {
            $query->set('post_type', ['cases_studies','goals', 'page', 'attachment']);
            $query->set('post_status', ['publish', 'inherit']);
        }
    }

    return $query;
}

add_filter( 'pre_get_posts', 'med_search_post_types' );