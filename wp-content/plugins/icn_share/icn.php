<?php
/**
 * Plugin Name: ICN Social Share
 * Description: Social share plugin
 * Version: 1
 * Author: Ralph
 * Author URI: http://www.acw.uk.com/
 **/

/**
 * Register and enqueues public-facing JavaScript files.
 **/

function enqueue_opengraph_script() {
    wp_enqueue_script( 'acw_opengraph', plugins_url('icn_share/assets/js/acw_opengraph.js'), array('jquery'), '', true);
}
add_action('wp_footer','enqueue_opengraph_script');

include_once (__DIR__ . '/acw-opengraph.php');
