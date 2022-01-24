<?php

global $post;
$long_title = get_field('long_title');
$feature_image = get_feature_image_url();
$goals = \ICN\Query::post_type_cf_order_by(['goals'], -1, 'menu_order', 'asc');

get_header();
if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
        <div class="masterheader parallax-window" data-parallax="scroll" data-image-src="<?=$feature_image; ?>"></div>
        <div class="container main-container <?=($feature_image)? : 'no_feature_image'?>">
            <div class="row">
                <div class="col-sm-12 col-md-10 offset-md-1">

                    <div class="page-content page-<?= $post->post_name; ?> page-type-<?=$post->post_type?>">
                        <div class="content-entry">
                            <h1><?= ($long_title)? $long_title: $post->post_title ;?></h1>
                            <p><?= apply_filters('the_content', $post->post_content); ?></p>
                            <div class="clr20"></div><?php
                            if ( $goals ):  ?>
                                <ul class="nav nav-tabs row sdglist" role="tablist"><?php
                                    foreach ($goals as $key => $goal) : ?>
                                        <li role="presentation" class="col-xs-6 col-sm-4 col-md-3 col-lg-2 goal_box <?= ! $key ? 'active':''; ?>">
                                            <a href="#goal_<?= ($key + 1); ?>" data-controls="goal_<?= $key + 1; ?>" aria-controls="goal_<?= ($key + 1);?>" role="tab" data-toggle="tab">
                                                <img src="<?= get_template_directory_uri(); ?>/assets/img/goals_icon/sdg_icons_<?= ICL_LANGUAGE_CODE.'-'. ($key + 1); ?>.svg"/>
                                            </a>
                                        </li><?php
                                    endforeach; ?>
                                    <li class="col-xs-6 col-sm-4 col-md-3 col-lg-2 goal_box">
                                        <a href="http://www.un.org/sustainabledevelopment/sustainable-development-goals/" target="_blank">
                                            <img src="<?= get_template_directory_uri(); ?>/assets/img/goals_icon/sdg_icons_<?= ICL_LANGUAGE_CODE;?>-18.svg"/>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="tab-sdgs"><?php
                                    foreach( $goals as $key => $goal ) :
                                        $goalId = '"' . $goal->ID . '"';
                                        $goal_case_studies = \ICN\Query::post_type_cf(['case_studies'], -1, 'related_goals', $goalId, 'LIKE'); ?>

                                        <div role="tabpanel" class="tab-pane goal-pane fade <?= ! $key ? 'active show' : ''; ?>" id="goal_<?= ($key + 1); ?>">
                                            <h2><?= _x('Goal', 'theme', 'ICN') ?> <?= ($key + 1); ?>: <?= $goal->post_title; ?></h2>
                                            <?= apply_filters('the_content', $goal->post_content); ?><?php

                                            if ($goal_case_studies) : ?>
                                                <div class="clr20"></div>
                                                <ul class="caseStudyList"><?php
                                                    foreach ($goal_case_studies as $case_study): ?>
                                                        <li><a href="<?= get_permalink($case_study->ID); ?>"><?= $case_study->post_title; ?></a></li><?php
                                                    endforeach; ?>
                                                </ul><?php
                                            endif; ?>
                                        </div><?php
                                    endforeach; ?>
                                </div><?php
                            endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php
    endwhile;
else :
    get_template_part('template-parts/content', 'none');
endif;

get_footer(); ?>
