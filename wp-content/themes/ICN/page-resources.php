<?php

global $post;
$long_title = get_field('long_title');
$feature_image = get_feature_image_url();
$order_link = get_field('order_form_link');
$pdf_file = get_field('pdf_file');
$pdf_section_title = get_field('pdf_section_title');
$pdf_sections = get_field('pdf_sections');
get_header();
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post(); ?>
                        <div class="masterheader parallax-window" data-parallax="scroll" data-image-src="<?=$feature_image; ?>"></div>
                        <div class="container main-container <?=($feature_image)? : 'no_feature_image'?>">
                            <div class="row">
                                <div class="col-sm-12 col-md-10 offset-md-1">

                                    <div class="page-content page-<?= $post->post_name; ?> page-type-<?=$post->post_type?>">
                                        <div class="content-entry">
                                            <div class="content-entry">
                                                <h1><?= ($long_title)? $long_title: $post->post_title ;?></h1>
                                                <p><?= get_the_content(); ?></p>
                                                <div class="clr20"></div><?php
//                                                if($order_link):?>
<!--                                                    <a href="--><?//=$order_link ?><!--" target="_blank" class="icn-btn">--><?//= _x('Order here','theme','ICN'); ?><!--</a><div class="clr30"></div>--><?php
//                                                endif;
//                                                if($order_link):?>
<!--                                                    <a href="--><?//=$pdf_file ?><!--" target="_blank" class="icn-btn">--><?//= _x('Download the PDF here','theme','ICN'); ?><!--</a><div class="clr50"></div>--><?php
//                                                endif; ?>
                                                <!-- <h2 style="margin-bottom: 30px;">IND Report</h2> -->

                                                <?php

                                                // check if the repeater field has rows of data
                                                if( have_rows('guidance_pack') ):

                                                    // loop through the rows of data
                                                    while ( have_rows('guidance_pack') ) : the_row();

                                                        if( have_rows('languages') ):

                                                            while( have_rows('languages') ): the_row();

                                                                // vars
                                                                $language = get_sub_field('language');
                                                                $file = get_sub_field('file');
//

                                                                ?>

                                                                    <div style="margin-bottom: 20px">
                                                                        <?php
                                                                        if( $file ): ?>
                                                                            <a class="icn-btn" href="<?php echo $file; ?>" >Download File in <?php echo $language; ?></a><br>
                                                                        <?php endif; ?>
                                                                    </div>
                                                            <?php
                                                            endwhile;
                                                        endif;

                                                    endwhile;
                                                endif;

                                                ?>


                                                <?php /*=_x('Or View Online by Section', 'theme', 'ICN');*/?>
<!--                                                <div class="clr30"></div>-->
                                                <?php
                                                if($pdf_sections):
                                                    foreach ($pdf_sections as $key=>$pdf_section): ?>
                                                        <a href="<?=$pdf_section['sub_section_link'] ?>"  target="_blank" class="section_link" data-toggle="modal" data-target="#pdf_section_<?=$key;?>"><?=$pdf_section['sub_section_title'] ?></a>
                                                        <div class="clearfix"></div>
                                                        <?php
                                                    endforeach;
                                                endif; ?>

                                    
                                                <?php
                                                if( have_rows('fact_sheets') ): ?>
                                                    <!--     Fact sheets     -->
                                                <h2> Fact Sheets</h2>
                                                <?php
                                                 while ( have_rows('fact_sheets') ) : the_row();

                                                    if( have_rows('languages') ):
                                                     while( have_rows('languages') ): the_row();

                                                    $language = get_sub_field('language');
                                                    $file = get_sub_field('file');


                                                ?>
                                                 <div style="margin-bottom: 20px">
                                                     <?php
                                                     if( $file ): ?>
                                                         <a class="icn-btn" target="_blank" href="<?php echo $file; ?>" >Download Factsheet in <?php echo $language; ?></a><br>
                                                     <?php endif; ?>
                                                 </div>

                                                <?php
                                                     endwhile;
                                                    endif;
                                                 endwhile;
                                                endif;

                                                ?>
                                            </div>

                                            <?php
                                            if($pdf_sections):
                                                foreach ($pdf_sections as $key=>$pdf_section): ?>

                                                <div class="modal fade modal-pdf" id="pdf_section_<?=$key;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <object type="application/pdf" data="<?=$pdf_section['sub_section_link'] ?>" width="100%" height="400" style="height: 70vh;">No Support</object>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div><?php

                                                endforeach;
                                            endif; ?>

                                            <div class="clr20"></div>

                                            <?php
                                                if(have_rows('logos')):?>
                                                    <h2 style="margin-top: 40px; margin-bottom: 30px;">Logos</h2>
                                                    <div class="row">
                                                        <?php if(get_field('image')) : ?>
                                                            <div class="col-12">
                                                                <img src="<?= get_field('image')?>" alt="Logo single">
                                                            </div>
                                                        <?php endif;?>
                                                    </div>

                                                    <div class="row"><?php
                                                    while ( have_rows('logos') ) : the_row(); ?>
                                                        <div class="col-xs-12 col-sm-4 text-center">
                                                            <a href="<?php the_sub_field('logo'); ?>" target="_blank"><img src="<?php the_sub_field('logo'); ?>" class="img-fluid"/></a>
                                                            <div class="clr5"></div>
                                                            <a href="<?php the_sub_field('logo'); ?>" target="_blank"><?php the_sub_field('logo_text'); ?></a>
                                                        </div><?php
                                                    endwhile; ?>
                                                    </div><?php
                                                endif; ?>
                                            <div class="clr20"></div><?php

                                                if( have_rows('shared_files') ):?>

                                                    <h2 style="margin-top: 40px; margin-bottom: 30px;">Posters</h2><?php
                                                    while ( have_rows('shared_files') ) : the_row(); ?>
                                                        <div style="padding-bottom: 20px;"><a href="<?php the_sub_field('file'); ?>" target="_blank" class="icn-btn"><?php the_sub_field('link_text'); ?></a></div><?php

                                                    endwhile;
                                                endif;


                                                if(have_rows('quote_cards')):?>

                                                <h2 style="margin-top: 40px; margin-bottom: 30px;">Quote Cards</h2>
                                                    <div class="row"><?php
                                                        while ( have_rows('quote_cards') ) : the_row(); ?>
                                                            <div class="col-xs-12 col-sm-4 text-center d-flex justify-content-center align-items-center"><img src="<?php the_sub_field('image'); ?>" class="img-fluid"/>
                                                                <div class="clr5"></div>
                                                                <a href="<?php the_sub_field('image'); ?>" download>Download: <i class="fa fa-download" aria-hidden="true"></i></a>
                                                            </div><?php

                                                        endwhile;?>

                                                    </div><?php
                                                endif;
                                                if( have_rows('videos') ):
                                            ?>
                                            <h2 style="margin-top: 40px;margin-bottom: 30px;">Videos</h2>

                                            <div class="videos">
                                                <div class="video-mobile"></div>
                                                <?php
                                                ?>
                                                    <div class="videos-box">
                                                        <div class="video">
                                                            <?php
                                                            while ( have_rows('videos') ) : the_row(); ?>
                                                            <div class="col-video">
                                                                <div class="overlay"></div>
                                                                <h4><?php the_sub_field('video_title');?></h4>
                                                                <div class="embed-container">
                                                                    <?php the_sub_field('video'); ?>
                                                                </div>
                                                            </div>
                                                    <?php endwhile;?>
                                                        </div>
                                                    </div>
                                            </div>
                                                <?php
                                                endif;
                                            ?>

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


<script>
    $(function(){
        if($('.video-mobile').css('display') == 'none'){
            $('.col-video').first().appendTo('.videos');
            $('.col-video').on('click', function(){
                if($(".videos > .col-video").length > 0) {
                    $(".videos > .col-video iframe").attr('src', $(".videos > .col-video iframe").attr('src').replace('?autoplay=1', '') + '?feature=oembed');
                    $(".videos > .col-video").appendTo('.video');
                }
                // Append selected video to the right column
                $(this).appendTo('.videos');
                // Autoplay video
                $(".videos > .col-video iframe").attr('src', $(".videos > .col-video iframe").attr('src').replace('?feature=oembed', '') + '?autoplay=1');

            });
        }

    })
</script>
