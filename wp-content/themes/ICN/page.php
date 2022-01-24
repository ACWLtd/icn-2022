<?php

global $post;
$long_title = get_field('long_title');
$feature_image = get_feature_image_url();
get_header();
if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
        <div class="masterheader parallax-window" data-parallax="scroll" data-image-src="<?=$feature_image; ?>"></div>
        <div class="container main-container <?=($feature_image)? : 'no_feature_image'?>">
            <div class="row">
                <div class="col-sm-12 col-md-10 offset-md-1">

                    <div class="page-content page-<?= $post->post_name; ?>">
                        <div class="content-entry">
                            <h1><?= ($long_title)? $long_title: $post->post_title ;?></h1>
                            <p><?php the_content(); ?></p>
                            <div class="clr20"></div>
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
