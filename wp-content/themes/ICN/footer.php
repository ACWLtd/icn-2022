<?php
    $footer_add = get_field('address', 'option');
    $footer_tel = get_field('telephone', 'option');
    $footer_fax = get_field('fax', 'option');
    $footer_email = get_field('email', 'option');
    $footer_general_enquire = get_field('website_inquiries', 'option');
    $footer_media_enquire = get_field('media_inquries','option');
    $footer_share_story = get_field('share_your_story','option');
    $ftlnks = get_field('footer_links','option');
    $fb_lnk = get_field('facebook_link','option');
    $tw_lnk = get_field('twitter_link','option');
    $ln_lnk = get_field('linkedin_link','option');
?>
    <footer>
        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-md-center">
                        <p><?= $footer_add; ?></p>
                        <div class="clr20"></div>
                        <ul class="contactlnks"><?php
                            if($footer_tel): ?>
                                <li><label><?= _x('Telephone','theme','ICN')?></label><div class="clearfix"/><span><?= $footer_tel; ?></span></li><?php
                            endif;
                            if($footer_email): ?>
                                <li><label><?= _x('Email','theme','ICN')?></label><div class="clearfix text-lowercase"/><span><?= $footer_email; ?></span></li><?php
                            endif;
                            if($footer_general_enquire): ?>
                                <li><label><?= _x('General Inquiries','theme','ICN')?></label><div class="clearfix"/><span><?= $footer_general_enquire; ?></span></li><?php
                            endif;
                            if($footer_media_enquire): ?>
                                <li><label><?= _x('Media Inquiries','theme','ICN')?></label><div class="clearfix"/><span><?= $footer_media_enquire; ?></span></li><?php
                            endif;
                            if($footer_share_story): ?>
                                <li><label><?= _x('Share your story','theme','ICN')?></label><div class="clearfix"/><span><a href="<?= get_permalink( icl_object_id(25, 'page', false, ICL_LANGUAGE_CODE)); ?>"><?= _x('Click here','theme','ICN')?></span></li><?php
                            endif;  ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"/>
        <div id="footer_links">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-md-center">
                        <ul class="pagelnks"><?php
                          if($ftlnks):
                              foreach ($ftlnks as $ftlnk):
                                  if($ftlnk['this_is_a_external_link']): ?>
                                    <li><a href="<?=$ftlnk['external_url'] ?>" target="_blank"><?=$ftlnk['external_link_title'] ?></a></li>
                                  <?php  else: ?>
                                    <li><a href="<?= get_permalink($ftlnk['internal_page']->ID); ?>"><?= $ftlnk['internal_page']->post_title; ?></a></li>
                                  <?php endif; ?>
                              <?php
                              endforeach;
                            endif;
                        ?></ul>
                        <ul class="socialnks"><?php
                            if($fb_lnk): ?>
                                <li><a href="<?= $fb_lnk; ?>" target="_blank"><img src="<?= get_template_directory_uri();?>/assets/img/facebook-64.png" alt="ICN FaceBook"/></a></li><?php
                            endif;
                            if($tw_lnk): ?>
                                <li><a href="<?= $tw_lnk; ?>" target="_blank"><img src="<?= get_template_directory_uri();?>/assets/img/twitter-64.png" alt="ICN Twitter"/></a></li><?php
                            endif;
                            if($ln_lnk): ?>
                                <li><a href="<?= $ln_lnk; ?>" target="_blank"><img src="<?= get_template_directory_uri();?>/assets/img/linkedIn-64.png" alt="ICN LinkedIn"/></a></li><?php
                            endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"/>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 text-xs-center text-sm-center text-acw">
                    <a href="http://acw.uk.com" target="_blank" style="color:#999; font-size: 9px; text-transform: uppercase;">Designed and Produced by ACW</a>
                </div>
            </div>
        </div>
    </footer><?php
    wp_footer(); ?>
    </div><!-- #wma-wrapper -->


    
</body>
</html>
