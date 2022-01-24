<?php
get_header();
?>

    <div class="masterheader parallax-window" data-parallax="scroll" data-image-src="<?=get_template_directory_uri(); ?>/assets/img/POSTER_NURSE_CHINA.jpg"></div>
        <div class="container main-container">
            <div class="row">
                <div class="col-sm-12 col-md-10 offset-md-1">

                    <div class="page-content search-page">
                        <div class="content-entry">
                            <h1><?= strtoupper(_x('Search', 'theme', 'ICN')); ?></h1>
                            <p class="page-summary"><em></em><?= get_search_query(); ?></em></p>
                            <div class="clr20"></div>
                            <form action="<?= get_home_url(); ?>" class="form-inline search-form">
                                <div class="form-group">
                                    <input type="hidden" name="search_type" value="general" />
                                    <input type="search" name="s" class="form-control" placeholder="<?= _x('Keywords', 'theme', 'wma'); ?>" value="<?= get_search_query(); ?>">
                                </div>
                                <button type="submit" class="btn btn-default">Search</button>
                            </form>
                            <div class="clr30"></div><?php
                            if ( have_posts() ) :
                                while ( have_posts() ) :
                                    the_post();
                                    $post_type = $post->post_type;
                                    $menuPage = strtolower($post_type) == 'page' ? $post : \ICN\Misc::getRepeaterFieldValue(get_field('cpt_pages', 'options'), $post_type);
                                    $med_post = new \ICN\Post($post, $menuPage);
                                    $root = $menuPage ? $med_post->get_root() : null; ?>

                                    <div class="content-wrapper clearfix search-result-wrapper">
                                        <div class="result">
                                            <span class="title"><?php
                                                the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?>
                                            </span>
                                            <br class="hidden-md-up">
                                            <span class="result-meta">
                                                <span class="hidden-sm-down">&ndash;</span> <?= _x('Uploaded', 'theme', 'wma'); ?> <?php
                                                the_time('D, d/m/Y'); ?>
                                                <?= _x('in', 'theme', 'wma'); ?> <?php
                                                if ( $root ) : ?>
                                                    <a href="<?= get_permalink($root->ID); ?>"><?= $root->post_title; ?></a> <?php
                                                else : ?>
                                                    <span class="search-category"><?= _x('Media', 'theme', 'wma'); ?></span><?php
                                                endif; ?>
                                            </span>
                                        </div>
                                    </div> <?php
                                endwhile; ?>
                                <div class="clr20"></div>
                                <div class="search-pagination">
                                <?= paginate_links(); ?>
                                </div><?php
                            else :
                                echo _x('Nothing matched your search. Please try again with different key words.', 'theme', 'wma');
                            endif; ?>


                        </div>

                    </div>
                </div>
            </div>
        </div><?php
get_footer();
