<?php

global $post;
$long_title = get_field('long_title');
$feature_image = get_feature_image_url();
//$caseStudies = \ICN\Query::post_type_cf_order_by_paginate('case_studies', -1, 'data','DESC', null, null, "=", false);

$search = new \ICN\CaseStudySearch(15);
$results = $search->getResults();
$caseStudy = '';
$country = get_field('country', $caseStudy->ID);
get_header();
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post(); ?>
                        <div class="masterheader parallax-window" data-parallax="scroll" data-image-src="<?=$feature_image; ?>"></div>
                        <div class="container main-container <?=($feature_image)? : 'no_feature_image'?>">
                            <div class="row">
                                <div class="col-sm-12 col-md-10 offset-md-1">
                                    <div class="page-content page-<?= $post->post_name; ?> page-type-<?=$post->post_type?>">
                                        <div class="content-entry">
                                            <h1 class="text-capitalize"><?= ($long_title)? $long_title: $post->post_title ;?></h1>

                                            <?php
                                            the_content();
                                            if($results): ?>
                                                <div class="case_study_panel"><?php
                                                    foreach ($results['posts'] as $key=>$caseStudy):
                                                        $cs_featuredImg = $country = $value = $label = '';
                                                        if(has_post_thumbnail( $caseStudy->ID )):
                                                            $cs_featuredImg = get_the_post_thumbnail( $caseStudy->ID, 'medium', array( 'class' => 'thumbnail', 'alt' => $caseStudy->post_title) );

                                                            $country = get_field('country', $caseStudy->ID);
                                                        endif; ?>

                                                        <div class="square col-case-study" id="case-study-<?=$key;?>">
                                                            <a href="<?= get_permalink($caseStudy->ID) ?>" title="<?= $caseStudy->Post_title; ?>">
                                                                 <div class="overlay"></div>
                                                                <div class="cover-img"><?php
                                                                    if($cs_featuredImg):
                                                                        echo $cs_featuredImg;
                                                                    else: ?>
                                                                    <img src="<?= icn_get_default_image('case_study')?>"  alt="<?= $caseStudy->post_title; ?>"/><?php
                                                                    endif; ?>
                                                                     </div>
                                                                 <div class="case_study_box" id="case_study_box_<?=$key;?>">
                                                                     <div class="case_study_details">
                                                                         <div class="wrapper">
                                                                             <h6 class="heading"><?= $caseStudy->post_title; ?></h6>
                                                                             <div class="clearfix"></div>
                                                                             <span class="country_name"><?= get_field('country', $caseStudy->ID); ?></span>

                                                                         </div>

                                                                     </div>
                                                                 </div>
                                                            </a>
                                                        </div><?php
                                                    endforeach; ?>
                                                </div>
                                                <?php
                                            endif; ?>
                                            <div class="clearfix"></div><?php
                                            if ( array_key_exists('pagination', $results) && $results['pagination'] ) : ?>
                                                <div class="clr20"></div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-pagination">
                                                        <div class="pagination">
                                                            <?= $results['pagination']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                               <?php
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
