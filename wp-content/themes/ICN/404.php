<?php

$uri = untrailingslashit(urldecode_deep($_SERVER['REQUEST_URI']));
$uriArr = explode('/', $uri);
$s = $uri;

if ( $uriArr ) {
    $newS = '';
    foreach ( $uriArr as $segment ) {
        if ( strlen(trim($segment)) )
            $newS .= "$segment ";
    }

    if ( strlen(trim($newS)) )
        $s = trim($newS);
}

$postsPerPage = -1;
$inputs = compact('s');
$search = new \ICN\Search404($inputs, $postsPerPage);
$results = $search->getResults();

get_header(); ?>

    <div class="masterheader parallax-window" data-parallax="scroll"  data-image-src="<?=get_template_directory_uri(); ?>/assets/img/POSTER_NURSE_CHINA.jpg"></div>
    <div class="container main-container">
        <div class="row">
            <div class="col-sm-12 col-md-10 offset-md-1">
                    <h1><?= strtoupper(_x('Error 404', 'theme', 'wma')); ?></h1>
                    <div class="clr20"></div>
                        <form action="<?= get_home_url(); ?>" class="form-inline search-form">
                            <div class="form-group">
                                <input type="hidden" name="search_type" value="general" />
                                <input type="search" name="s" class="form-control" placeholder="<?= _x('Keywords', 'theme', 'wma'); ?>" value="<?= $s; ?>">
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form><?php
                        if ( array_key_exists('posts', $results) && $results['posts'] ) : ?>
                            <div class="clr30"></div>
                            <h4 class="text-uppercase">
                                <?= _x('The page you are looking for cannot be found. <br> Perhaps one of the pages below is what you\'re looking for.', 'theme', 'wma'); ?>
                            </h4><?php

                            foreach ( $results['posts'] as $result ) :
                                $post_type = $result->post_type;
                                $menuPage = strtolower($post_type) == 'page' ? $result : \ICN\Misc::getRepeaterFieldValue(get_field('cpt_pages', 'options'), $post_type);
                                $med_post = new \ICN\Post($result, $menuPage);
                                $root = $menuPage ? $med_post->get_root() : null; ?>

                                <div class="content-wrapper clearfix search-result-wrapper">
                                    <div class="result">
                                        <span class="title">
                                            <a href="<?= get_permalink($result->ID); ?>"><?= $result->post_title; ?></a>
                                        </span>
                                        <span class="result-meta">
                                            &ndash; <?= _x('Uploaded', 'theme', 'wma'); ?>
                                            <?= get_the_time('D, d/m/Y', $result->ID); ?>
                                            <?= _x('in', 'theme', 'wma'); ?> <?php
                                            if ( $root ) : ?>
                                                <a href="<?= get_permalink($root->ID); ?>"><?= $root->post_title; ?></a> <?php
                                            else : ?>
                                                <?= _x('Media', 'theme', 'wma'); ?> <?php
                                            endif; ?>
                                        </span>
                                    </div>
                                </div> <?php
                            endforeach;
                            if ( array_key_exists('pagination', $results) && $results['pagination'] ) : ?>
                                <div class="clr20"></div>
                                <div class="search-pagination">
                                    <?= $results['pagination']; ?>
                                </div><?php
                            endif;
                        else : ?>
                            <div class="clr30"></div>
                            <h4 class="page-title text-uppercase">
                                <?= _x('The page you are looking for cannot be found. Please try searching for it.', 'theme', 'wma'); ?>
                            </h4><?php
                        endif; ?>
                    </div>

                </div>
            </div><!-- /.row-main --><?php
wp_reset_query();
get_footer();
