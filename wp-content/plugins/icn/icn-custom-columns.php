<?php

/**
 * ICN - Custom Columns
 * This will add custom columns to custom post types.
 **/


/**
 * Define media columns
 * @return array
 */
function set_media_columns() {
    return [
        'cb' => '<input type="checkbox" />',
        'title' => _x('File', 'plugin', 'wma'),
        'author' => _x('Author', 'plugin', 'wma'),
        'types' => _x('Types', 'plugin', 'wma'),
        'parent' => _x('Uploaded to', 'plugin', 'wma'),
        'date' => _x('Date', 'plugin', 'wma'),
    ];
}
add_filter('manage_media_columns', 'set_media_columns');


/**
 * Manage media custom columns
 * @param $column
 * @param $post_id
 */
function custom_media_columns($column, $post_id) {
    switch( $column ) {
        case 'types' :
            $types = get_the_terms($post_id, 'media_types');

            if ( is_array($types) && count($types) ) {
                $html = '';
                $url =  admin_url('upload.php');

                foreach ($types as $key => $type) {
                    $params = ['lang' => ICL_LANGUAGE_CODE, 'media_types' => $type->slug, 'post_type' => 'attachment'];
                    $url = add_query_arg($params, $url);
                    $html .= "<a href='$url'>" . $type->name . "</a>";
                    if ( $key != count($types) - 1 )
                        $html .= ', ';
                }

                echo $html;
            }
            else
                echo "-";

            break;
    }

}
add_action( 'manage_media_custom_column', 'custom_media_columns', 10, 2 );



/**
 * Define blogs columns
 * @return array
 */
function set_case_studies_columns() {
    return [
        'cb' => '<input type="checkbox" />',
        'title' => _x('Title', 'plugin', 'icn'),
        'goal'  => _x('Goal', 'plugin', 'icn'),
        'date' => _x('Date', 'plugin', 'icn'),
    ];

}
add_filter('manage_case_studies_posts_columns', 'set_case_studies_columns');


/**
 * Manage blogs custom columns
 * @param $column
 * @param $post_id
 */
function custom_case_studies_columns( $column, $post_id ) {
    global $post;
    switch( $column ) {
        case 'goal' :
            $terms = get_field('related_goals', $post_id);

            /* If terms were found. */
            if ( !empty( $terms ) ) {

                $out = array();

                /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                foreach ( $terms as $term ) {
                    $out[] = sprintf( '%s',
                        $term->post_title
                    );
                }

                /* Join the terms, separating them with a comma. */
                echo join( ', ', $out );
            }

            /* If no terms were found, output a default message. */
            else {
                _e( 'No Category' );
            }

        break;
        default:
            break;

    }
}
add_action( 'manage_case_studies_posts_custom_column', 'custom_case_studies_columns', 10, 2 );
