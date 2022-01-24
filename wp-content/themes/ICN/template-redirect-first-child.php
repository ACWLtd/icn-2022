<?php
/**
 * Template Name: Page - 301 Redirect First Child
 */

global $post;
$children = get_children(['post_parent' => $post->ID, 'post_status' => 'publish', 'post_type' => 'page', 'orderby' => 'menu_order', 'order' => 'ASC']);

if ( $children ) {
    $firstChild = array_slice($children, 0, 1)[0];
    wp_redirect( get_the_permalink($firstChild->ID), 301 );
    exit();
}
