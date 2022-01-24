<?php

namespace ICN;

/**
 * Post type Queries
 * Class Query
 */
class Query
{
    /**
     * Query custom post type
     * @param array $type
     * @param int $num
     * @param null $metaKey
     * @param null $metaValue
     * @param string $metaType
     * @param int $suppress_filters
     * @return array
     */
    public static function post_type_cf( $type = [], $num = -1, $metaKey = null, $metaValue = null, $metaType = '=', $suppress_filters = false )
    {
        return get_posts([
            'post_type'	    => $type,
            'numberposts'	=> $num,
            'meta_query' => [
                [
                    'key' => $metaKey,
                    'value' => $metaValue,
                    'compare' => $metaType
                ]
            ],
            'suppress_filters' => $suppress_filters
        ]);
    }

    /**
     * Query custom post types constrained by multiple custom fields
     * @param array $type
     * @param int $num
     * @param array $metaQuery
     * @param int $suppress_filters
     * @return array
     */
    public static function post_type_multiple_cf($type = [], $num = -1, $metaQuery = [], $suppress_filters = false)
    {
        return get_posts([
            'post_type'	    => $type,
            'numberposts'	=> $num,
            'meta_query'    => $metaQuery,
            'suppress_filters' => $suppress_filters
        ]);
    }

    /**
     * Query custom post types and order by date unless specified
     * @param array $type
     * @param int $num
     * @param string $orderBy
     * @param string $order
     * @param null $metaKey
     * @param null $metaValue
     * @param string $metaType
     * @param array $excludeIds
     * @param int $suppress_filters
     * @return mixed
     */
    public static function post_type_cf_order_by($type = [], $num = -1, $orderBy = 'date', $order = 'DESC', $metaKey = null, $metaValue = null, $metaType = '=', $excludeIds = [], $suppress_filters = false)
    {
        return get_posts([
            'post_type'	    => $type,
            'numberposts'	=> $num,
            'orderby' => $orderBy,
            'order' => $order,
            'meta_query' => [
                [
                    'key' => $metaKey,
                    'value' => $metaValue,
                    'compare' => $metaType
                ]
            ],
            'exclude' => $excludeIds,
            'suppress_filters' => $suppress_filters
        ]);
    }

    /**
     * Query custom post types constrained by multiple custom fields and order by date unless specified
     * @param $type
     * @param int $num
     * @param string $orderBy
     * @param string $order
     * @param array $metaQuery
     * @return array
     */
    public static function post_type_multiple_cf_order_by($type = [], $num = -1, $orderBy = 'date', $order = 'DESC', $metaQuery = [], $excludeIds = [])
    {
        return get_posts([
            'post_type'	    => $type,
            'numberposts'	=> $num,
            'orderby' => $orderBy,
            'order' => $order,
            'meta_query'    => $metaQuery,
            'exclude' => $excludeIds,
            'suppress_filters' => false
        ]);
    }

    /**
     * Query custom post types and order by custom field value
     * @param array $type
     * @param int $num
     * @param string $orderBy
     * @param string $order
     * @param null $metaKey
     * @param null $metaValue
     * @param string $metaType
     * @param array $excludeIds
     * @return array
     */
    public static function post_type_cf_order_by_cf($type = [], $num = -1, $orderBy, $order, $metaKey = null, $metaValue = null, $metaType = '=', $suppress_filters = false, $excludeIds = [], $numeric = false)
    {
        return get_posts([
            'post_type'	    => $type,
            'numberposts'	=> $num,
            'meta_key' => $orderBy,
            'orderby' => $numeric ? 'meta_value_num' : 'meta_value',
            'order' => $order,
            'meta_query' => [
                [
                    'key' => $metaKey,
                    'value' => $metaValue,
                    'compare' => $metaType
                ]
            ],
            'exclude' => $excludeIds,
            'suppress_filters' => $suppress_filters
        ]);
    }

    /**
     * Query custom post types constrained by multiple custom fields and order by custom field value
     * @param array $type
     * @param int $num
     * @param $orderBy
     * @param string $order
     * @param array $metaQuery
     * @param array $excludeIds
     * @return array
     */
    public static function post_type_multiple_cf_order_by_cf($type = [], $num = -1, $orderBy, $order = 'DESC', $metaQuery = [], $excludeIds = [])
    {
        return get_posts([
            'post_type'	    => $type,
            'numberposts'	=> $num,
            'meta_key' => $orderBy,
            'orderby' => 'meta_value',
            'order' => $order,
            'meta_query'    => $metaQuery,
            'exclude' => $excludeIds,
            'suppress_filters' => false
        ]);
    }

    /**
     * Define pagination args
     * @param $query
     * @return array
     */
    public static function get_pagination_args($query)
    {
        return [
            'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $query->max_num_pages
        ];
    }

    /**
     *Query custom post types and order by date unless specified; paginate
     * @param array $type
     * @param int $num
     * @param string $orderBy
     * @param string $order
     * @param null $metaKey
     * @param null $metaValue
     * @param string $metaType
     * @param array $excludeIds
     * @return array
     */
    public static function post_type_cf_order_by_paginate($type = [], $num = -1, $orderBy = 'date', $order = 'DESC', $metaKey = null, $metaValue = null, $metaType = '=', $suppress_filters = false, $excludeIds = [])
    {
        $query = new \WP_Query();

        $posts =  $query->query([
            'post_type'	    => $type,
            'posts_per_page'	=> $num,
            'orderby' => $orderBy,
            'order' => $order,
            'meta_query' => [
                [
                    'key' => $metaKey,
                    'value' => $metaValue,
                    'compare' => $metaType
                ]
            ],
            'exclude' => $excludeIds,
            'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1 ),
            'suppress_filters' => $suppress_filters
        ]);

        return ['posts' => $posts, 'pagination' => paginate_links(static::get_pagination_args($query))];
    }


    /**
     * Query custom post types and order by custom field; paginate
     * @param array $type
     * @param int $num
     * @param $orderBy
     * @param $order
     * @param null $metaKey
     * @param null $metaValue
     * @param string $metaType
     * @param int $suppress_filters
     * @param array $excludeIds
     * @param null $numeric
     * @return array
     */
    public static function post_type_cf_order_by_cf_paginate($type = [], $num = -1, $orderBy, $order, $metaKey = null, $metaValue = null, $metaType = '=', $suppress_filters = false, $excludeIds = [], $numeric = false)
    {
        $query = new \WP_Query();

        $posts =  $query->query([
            'post_type'	    => $type,
            'posts_per_page'	=> $num,
            'meta_key' => $orderBy,
            'orderby' => $numeric ? 'meta_value_num' : 'meta_value',
            'order' => $order,
            'meta_query' => [
                [
                    'key' => $metaKey,
                    'value' => $metaValue,
                    'compare' => $metaType
                ]
            ],
            'exclude' => $excludeIds,
            'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1 ),
            'suppress_filters' => $suppress_filters
        ]);

        return ['posts' => $posts, 'pagination' => paginate_links(static::get_pagination_args($query))];
    }

    /**
     * Query custom post types constrained by multiple custom fields and order by date unless specified; paginate
     * @param array $type
     * @param int $num
     * @param string $orderBy
     * @param string $order
     * @param array $metaQuery
     * @param array $excludeIds
     * @return array
     */
    public static function post_type_multiple_cf_order_by_paginate($type = [], $num = -1, $orderBy = 'date', $order = 'DESC', $metaQuery = [], $excludeIds = [])
    {
        $query = new \WP_Query();

        $posts =  $query->query([
            'post_type'	    => $type,
            'posts_per_page'	=> $num,
            'orderby' => $orderBy,
            'order' => $order,
            'meta_query'    => $metaQuery,
            'exclude' => $excludeIds,
            'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1 ),
            'suppress_filters' => false
        ]);

        return ['posts' => $posts, 'pagination' => paginate_links(static::get_pagination_args($query))];
    }


    /**
     * Query custom post types constrained by specified meta query + tax query
     * @param array $type
     * @param int $num
     * @param string $orderBy
     * @param string $order
     * @param array $metaQuery
     * @param array $taxQuery
     * @param array $excludeIds
     * @return array
     */
    public static function post_type_tax_query_order_by($type = [], $num = -1, $orderBy = 'date', $order = 'DESC', $metaQuery = [], $taxQuery = [], $excludeIds = [])
    {
        return get_posts([
            'post_type'	    => $type,
            'numberposts'	=> $num,
            'orderby' => $orderBy,
            'order' => $order,
            'meta_query'    => $metaQuery,
            'tax_query' => $taxQuery,
            'exclude' => $excludeIds,
            'suppress_filters' => false
        ]);
    }

}