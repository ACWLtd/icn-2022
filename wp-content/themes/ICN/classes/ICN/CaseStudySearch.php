<?php
/**
 * Created by PhpStorm.
 * User: Ling
 * Date: 11/04/2017
 * Time: 16:13
 */

namespace ICN;


class CaseStudySearch
{

    /**
     * For pagination
     * @var int
     */
    protected $postsPerPage;

    /**
     * The Wordpress Query
     * @var \WP_Query
     */
    public $WP_Query;

    /**
     * A huge number
     * @var int
     */
    protected $bigNumber;

    /**
     * NewsSearch constructor.
     *
     * @param $inputs
     * @param $metaQuery
     * @param int $postsPerPage
     */
    public function __construct($postsPerPage = 15)
    {

        $this->postsPerPage = $postsPerPage;
        $this->WP_Query = new \WP_Query();
        $this->bigNumber = 999999999;
    }

    /**
     * Get paginated search results
     * @return array
     */
    public function getResults()
    {
        $results = [];
        $results['posts'] = $this->getCaseStudyResults();
        $results['pagination'] = $this->getPaginationLinks();

        return $results;
    }

    /**
     * Generate pagination links
     * @return array|string|void
     */
    protected function getPaginationLinks()
    {
        $args = [
            'base' => str_replace( $this->bigNumber, '%#%', esc_url( get_pagenum_link( $this->bigNumber ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $this->WP_Query->max_num_pages
        ];

        return paginate_links($args);
    }

    /**
     * Get search results from the news section based on custom taxonomies.
     * @return array
     */
    protected function getCaseStudyResults()
    {

        $tax_query = [];
        $date_query = [];
        $meta_query = [];

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $posts =  $this->WP_Query->query([
            'post_type' => 'case_studies',
            'tax_query' => $tax_query,
            'date_query' => $date_query,
            'meta_query' => $meta_query,
            'posts_per_page' => $this->postsPerPage,
            'paged' => $paged,
            'suppress_filters' => false
        ]);

        return $posts;
    }

}