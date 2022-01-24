<?php

function add_opengraph_doctype($output) {
    return $output . '
    xmlns="https://www.w3.org/1999/xhtml"
    xmlns:og="https://ogp.me/ns#" 
    xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');




//Add Open Graph Meta Info from the actual article data
function twitter_facebook_open_graph() {
    global $post;

    $excerpt = get_bloginfo()."-".get_the_title();

    // Facebook
    echo '<meta property="fb:admins" content="1275083199230346"/>'; // Fb admin ID
    echo '<meta property="fb:app_id" content="1946794832265494"/>';
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:description" content="' . $excerpt . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="ICN | A Voice To Lead"/>';

    // Twitter
    echo '<meta name="twitter:card" content="summary_large_image" />';
    echo '<meta name="twitter:site" content="@ICN" />';
    echo '<meta name="twitter:title" content="‎' . get_the_title() . '" />';
    echo '<meta name="twitter:description" content="' . $excerpt . '" />';
    echo '<meta name="twitter:creator" content="‎@ICN" />';
    // Get image
    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'share_img');

    echo '<meta name="twitter:image" content="' . $featured_img_url . '" />';
    echo '<meta name="twitter:image:src" content="' . $featured_img_url . '" />';
    echo '<meta property="og:image" content="' . $featured_img_url . '"/>';
    echo '<meta property="og:image:alt" content="ICN | A Voice To Lead"/>';
}
add_action( 'wp_head', 'twitter_facebook_open_graph', 5 );


