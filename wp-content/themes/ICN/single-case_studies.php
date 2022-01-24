<?php

global $post;

//get page by post type from CPT option page

$menu_page = $post ? \ICN\Misc::getRepeaterFieldValue(get_field('cpt_pages', 'options'), $post->post_type) : null;
$feature_image =  get_the_post_thumbnail_url($menu_page->ID);
$quote = get_field('quote');
$title = get_field('title');
$firstname = get_field('submit_by_first_name');
$lastname = get_field('submit_by_surname');
$position = get_field('position');
$institution = get_field('institution');
$extra_submit = get_field('submit_by');


$country = get_field('country');
$image_slider = get_field('image_slider');
$goal_categories = get_field('related_goals');


get_header();
if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
        <div class="masterheader parallax-window" data-parallax="scroll" data-image-src="<?=$feature_image; ?>" style="min-height: 430px"></div>
        <div class="container main-container">
            <div class="row">
                <div class="col-sm-12 col-md-10 offset-md-1">

                    <div class="page-content page-<?= $post->post_name; ?> single-<?=$post->post_type?>">
                        <div class="content-entry">
                            <h1><?= $post->post_title ;?></h1>
                            <?php
                            if ( $goal_categories && count($goal_categories) ) : ?>
                                <div class="goals"><?php
                                    foreach ($goal_categories as $category):
                                        $goal_order = get_field('goal_order', $category->ID); ?>
                                        <img data-index="<?=$goal_order; ?>" src="<?= get_template_directory_uri()?>/assets/img/goals_icon/sdg_icons_<?= ICL_LANGUAGE_CODE; ?>-<?= $goal_order; ?>.svg"
                                                                                 alt="<?= $category->post_title; ?>" class="goal_icon"/><?php
                                    endforeach;
                                    ?>
                                </div>
                                <div class="clr20"></div>

                                <?php
                            endif;

                            if($firstname || $lastname ): ?>
                                <div class="submit"><strong><?= _x('Case Study Submitted by', 'theme','ICN'); ?>:</strong><?php
                                if($firstname) {
                                    echo ' '.$firstname;
                                }
                                if($lastname) {
                                    echo ' ' . $lastname;
                                }
                                if($position) {
                                    echo ', ' . $position;
                                }
                                if($institution) {
                                    echo ', ' . $institution;
                                }
                                if($extra_submit) {
                                    echo '<div class="clr10"></div>' . $extra_submit;
                                } ?>
                                </div><?php
                            endif;
                            ?>

                            <div class="submit"><strong>Country:</strong> <?= $country; ?></div>
                            <!-- Social Share -->
                            <div>
                                <ul class="top_social_lnks acw-social-share">
                                    <li> <div class="submit"><strong>Share Case Study:</strong></div> </li>
                                    <li><a href="" class="acw-social-share-fb"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="" class="acw-social-share-tw"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="" class="acw-social-share-li"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>

                            <?php
                            if($quote):?>
                                <blockquote><?= $quote; ?></blockquote><?php
                            endif;
                            if($image_slider): ?>
                                <div id="CaseStudyCarousel" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" role="listbox"><?php
                                    foreach ($image_slider as $key=>$slide): ?>
                                                <div class="carousel-item <?=($key==0)?'active': ''; ?>">
                                                    <div class="wrapper">
                                                        <img class="d-block" src="<?=$slide['image']['url']; ?>" alt="slide-<?=$key; ?> slide" />
                                                    </div>

                                                </div>
                                           <?php
                                    endforeach ?>
                                    </div>

                                    <a class="carousel-control-prev carousel-control" href="#CaseStudyCarousel" role="button" data-slide="prev">
                                        <i class="fa fa-angle-left fa-3x" aria-hidden="true"></i>
                                    </a>
                                    <a class="carousel-control-next carousel-control" href="#CaseStudyCarousel" role="button" data-slide="next">
                                        <i class="fa fa-angle-right fa-3x" aria-hidden="true"></i>
                                    </a>
                                </div><?php
                            endif ?>
                            <p><?= the_content(); ?></p>

                            <div>
                                <ul class="top_social_lnks acw-social-share">
                                    <li><div class="submit"><strong>Share Case Study:</strong></div></li>
                                    <li><a href="" class="acw-social-share-fb"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="" class="acw-social-share-tw"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="" class="acw-social-share-li"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                            <div class="clr20"></div>
                            <a href="<?= get_permalink(get_page_by_title(_x('Case Studies', 'theme','ICN')))?>" class="icn-btn">&laquo;&nbsp;<?= _x('Go Back to Case Studies List', 'theme','ICN'); ?></a>
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
?>

<?php
get_footer(); ?>
