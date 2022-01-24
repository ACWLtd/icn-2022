<?php

/**
 * Autoload, baby!
 */
spl_autoload_register(function ($class_name) {
    $file = get_stylesheet_directory() . '/classes/' . $class_name . '.php';
    $file = str_replace('\\', '/', $file);
    if( is_file($file) && ! class_exists($class_name) )
        include $file;
});

/**
 * Some setup housekeeping
 */
if ( ! function_exists( 'icn_setup' ) ) {
    function icn_setup() {
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array('search-form'));
        register_nav_menus(['primary' => esc_html__('Primary', '_s')]);
    }
}
add_action( 'after_setup_theme', 'icn_setup' );

/**
 * Allow Custom post types in feeds
 * @param $qv
 * @return mixed
 */
function icn_feed_request($qv) {
    if (isset($qv['feed']))
        $qv['post_type'] = get_post_types();
    return $qv;
}
add_filter('request', 'icn_feed_request');

/**
 * Get a definitive list of all TRIAL custom post types
 * @return array
 */
function icn_get_custom_post_types() {
    return ['questions','news'];
}

/**
 * Determine if supplied post type is a WMA custom post type
 * @param $post_type
 * @return bool
 */
function icn_is_custom_post_type($post_type) {
    return in_array($post_type, icn_get_custom_post_types());
}


/**
 * Show current template to super admins
 */
function icn_show_template() {
    if( is_super_admin() ){
        global $template;
        print_r($template);
    }
}
//add_action('wp_footer', 'icn_show_template');


/**
 * Enqueue scripts and styles.
 */
function icn_styles_and_scripts() {
    wp_enqueue_style( 'icn-style', get_template_directory_uri() . '/style.min.css' );
    wp_enqueue_script( 'icn-main', get_template_directory_uri() . '/app.js', [], '20170411', false);
    wp_enqueue_script( 'icn-countdown', get_template_directory_uri() . '/assets/js/library/jquery.countdown.min.js', [], '20170502', false);
    wp_enqueue_script( 'icn-twitter-feed', get_template_directory_uri() . '/assets/js/library/twitterFetcher_min.js', [], '20170502', false);
    wp_enqueue_script( 'icn-parallax', get_template_directory_uri() . '/assets/js/library/parallax.min.js', ['jquery'], '20170502', false);
    //wp_enqueue_script( 'icn-navgoco', get_template_directory_uri() . '/assets/js/library/jquery.navgoco.js', ['jquery'], '20170502', false);
    wp_enqueue_script( 'gp-recaptcha', 'https://www.google.com/recaptcha/api.js', [], '20170411', false);

}

add_action( 'wp_enqueue_scripts', 'icn_styles_and_scripts' );


/**
 * Google Recaptcha Site key
 * @return string
 */
function icn_get_google_recaptcha_site_key() {
    return '6LdqlRAUAAAAACgscIrZjTb_hbbkNeOp50PDWfla';
}

/**
 * Google Recaptcha secret key
 * @return string
 */
function icn_get_google_recaptcha_secret_key() {
    return '6LdqlRAUAAAAACllKCQiPRp1kTq-yFeLzd1LLRhD';
}


/**
 * echo TRIAL language switcher
 */
function icn_language_switcher() {
    $html = '';
    $languages = apply_filters('wpml_active_languages', NULL, ['skip_missing' => 1]);

    if( ! empty( $languages ) ) {
        $current = null;

        foreach( $languages as $lang) {
            if ( $lang['active'] ) {
                $current = $lang;
                break;
            }
        }

        $html = "<ul class='language-switcher text-sm-center text-md-right'>";
        $html .= "<li class='active-language'><span>" . $current['code'] . "</span></li>";

        $count = count($languages);
        $key = 0;

        foreach( $languages as $language ) {

            if ( ! $language['active'] )
                $html .= "<li><a href='" . $language['url'] . "'>" . $language['code'] . "</a></li>";

            if ( $key == ($count - 1) )
                $html .= "</ul>";
            $key++;
        }

        $html .= "</ul>";
    }

    echo $html;
}


/**
 * Construct single page HTML pagination string
 * @param $query
 * @param $permalink
 * @return string
 */
function icn_get_pagination($query, $permalink, $queryString){
    $max = (int)$query->max_num_pages;
    $suffix = '?' . $queryString;
    $html = '';

    if ( $max ) {
        $current = (int)$query->query['paged'];
        $previous = $current > 1 ? $current - 1 : null;
        $next = $current < $max ? $current + 1 : null;
        $previousDots = $current - 3 > 1;
        $previous1 = ( $current - 1 > 1 ) ? $current - 1 : null;
        $previous2 = ( $current - 2 > 1 ) ? $current - 2 : null;
        $next1 = ( $current + 1 < $max ) ? $current + 1 : null;
        $next2 = ( $current + 2 < $max ) ? $current + 2 : null;
        $nextDots = $current + 3 < $max;

        if ($previous) {
            $html .= "<a href='$permalink/$previous/$suffix' class='prev page-numbers'>&laquo; ";
            $html .= _x('Previous', 'theme', 'wma');
            $html .= "</a> ";
            $html .= "<a href='$permalink/1/$suffix' class='page-numbers'>1</a> ";
        }

        if ( $previousDots )
            $html .= "<span class='page-numbers dots'>...</span> ";

        if ( $previous2 )
            $html .= "<a href='$permalink/$previous2/$suffix' class='page-numbers'>$previous2</a> ";

        if ( $previous1 )
            $html .= "<a href='$permalink/$previous1/$suffix' class='page-numbers'>$previous1</a> ";

        $html .= "<span class='page-numbers current'>$current</span> ";

        if ( $next1 ) {
            $html .= "<a href='$permalink/$next1/$suffix' class='page-numbers'>$next1</a> ";
            if ( $next2 ) {
                $html .= "<a href='$permalink/$next2/$suffix' class='page-numbers'>$next2</a> ";
                if ( $nextDots )
                    $html .= "<span class='page-numbers dots'>...</span> ";
            }
        }

        if ( $current != $max )
            $html .= "<a href='$permalink/$max/$suffix' class='page-numbers'>$max</a> ";

        if ( $next ) {
            $html .= "<a href='$permalink/$next/$suffix' class='next page-numbers'> ";
            $html .= _x('Next', 'theme', 'wma');
            $html .= " &raquo;</a> ";
        }
    }

    return $html;
}



/**
 * Get current root page ID
 * @param $post
 * @return int
 */
function icn_get_current_root_id($post) {
    if ( $post->post_parent ) {
        $ancestors = get_post_ancestors($post->ID);
        $root = count($ancestors) - 1;
        return $ancestors[$root];
    } else {
        return $post->ID;
    }
}

/**
 * Get Facebook feed
 */

function getFacebookFeed(){
    //Set your App ID and App Secret.
    $appID = '112444145969059';
    $appSecret = '5f21727ef480d3b121ee8ed120768f98';

    //Create an access token using the APP ID and APP Secret.
    $accessToken = $appID . '|' . $appSecret;

    //The ID of the Facebook page in question.
    $id = '196338133712944';

    //Tie it all together to construct the URL
    $url = "https://graph.facebook.com/$id/posts?access_token=$accessToken";

    //Make the API call
    //$result = file_get_contents($url);

    //Decode the JSON result.
    $decoded = json_decode($result, true);

    return $decoded;
}

/**
 *  Get Goal no
 */

/**
 * Retrieve a post given its title.
 *
 * @uses $wpdb
 *
 * @param string $post_title Page title
 * @param string $post_type post type ('post','page','any custom type')
 * @param string $output Optional. Output type. OBJECT, ARRAY_N, or ARRAY_A.
 * @return mixed
 */
function get_post_by_title($page_title, $post_type ='post' , $output = OBJECT) {
    global $wpdb;
    $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type= %s", $page_title, $post_type));
    if ( $post )
        return get_post($post, $output);

    return null;
}

/*
 *  get the case studies by the goal name
 */
function get_case_studies_by_goal($goal_name){

    //$term = get_term($goal_name);

$args = array(

    //'category_name'    => $goal_name,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'post_type'        => 'case_studies',
    'post_status'      => 'publish',
    'post_per_page'    => -1,
    'tax_query'       => array(
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $goal_name
        )
    )
);


    $posts_array = get_posts( $args );

    return $posts_array;
}


/*
 *  Get Feature Image Url, if the page doesn't have feature image, it will check the parent page
 */
function get_feature_image_url(){
    global $post;
    $feature_image = get_the_post_thumbnail_url($post->ID);
    $parent_id = wp_get_post_parent_id($post->ID);
    if(!$feature_image)
    {
        $feature_image = get_the_post_thumbnail_url($parent_id);
    }
    return $feature_image;
}


/**
 * Get default featured image
 * @return string
 */
function icn_get_default_image($type) {

    $image_url = '';

    switch($type){
        case "feature_image":

            $image_url = get_stylesheet_directory_uri() . "/assets/img/feature_default.jpg";
        break;

        case "case_study":
            $image_url = get_stylesheet_directory_uri() . "/assets/img/Thumbnail.jpg";
        break;

    }

    return $image_url;
}


/*
 * Allow multiple selection for category dropdown
 */


function wp_dropdown_cats_multiple( $output, $r ) {

    if( isset( $r['multiple'] ) && $r['multiple'] ) {

        $output = preg_replace( '/^<select/i', '<select required multiple', $output );

        $output = str_replace( "name='{$r['name']}'", "name='{$r['name']}[]'", $output );

        foreach ( array_map( 'trim', explode( ",", $r['selected'] ) ) as $value )
            $output = str_replace( "value=\"{$value}\"", "value=\"{$value}\" selected", $output );

    }

    return $output;
}


add_filter( 'wp_dropdown_cats', 'wp_dropdown_cats_multiple', 10, 2 );
