<?php

global $post;

get_header(); ?>
        <div class="container main-container">
            <div class="row">
                <div class="col-sm-12 col-md-10 offset-md-1">

                    <div class="page-content page-<?= $post->post_name; ?>">
                        <div class="content-entry">
                            <h1><?= strtoupper(the_title()) ;?></h1>
                            <p class="page-summary"><i class="fa fa-file-image-o" aria-hidden="true"></i> <?= _x('Image Upload', 'theme', 'ICN'); ?></p>
                            <p><?php the_content(); ?></p>
                            <div class="clr20"></div>
                            <img class="img-fluid" src="<?= $post->guid; ?>" alt="<?= $post->post_title; ?>">
                            <div class="clr20"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div><?php
get_footer(); ?>
