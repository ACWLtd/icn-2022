<?php

require_once(ABSPATH . '/wp-admin/includes/image.php');
require_once(ABSPATH . '/wp-admin/includes/file.php');
require_once(ABSPATH . '/wp-admin/includes/media.php');

global $post;

$long_title = get_field('long_title');
$feature_image = get_feature_image_url();
$get_countries = get_field_object('field_58eb8b54784b2');
$get_titles = get_field_object('field_58fe02b51c06e');
$get_goals = \ICN\Query::post_type_cf_order_by(['goals'], -1, 'menu_order', 'asc');

$email_to = get_field('email_receipient_for_share_your_story','option');
$date = date('l jS \of F Y h:i:s A');
$options = [
    'post_id'		=> 'new_post',
    'post_title'	=> true,
    'post_content'	=> true,
    'new_post'		=> [
        'post_type'		=> 'case_studies',
        'post_status'	=> 'pending'
    ],
    'return'		=> home_url('share-your-story'),
    'submit_value'	=> 'Submit'
];

$hasError = $thankyouMsg = $firstname = $lastname = $position = $institution = $email = $title
    = $country = $relatedsdgs = $extraInfo = $casestudytitle = $casestudytxt = $images = $email_msg = $form_status = '';
$error = array();

if ( isset( $_POST['submitted'] ) ) {

    //Mandatory fields

    if ( trim( $_POST['firstname'] ) === '' ) {
        $error = _x('Please enter a first name', 'theme','ICN').'<br/>';
        $hasError = true;
    }
    else{
        $firstname = $_POST['firstname'];
    }
    if ( trim( $_POST['lastname'] ) === '' ) {
        $error = _x('Please enter a last name', 'theme','ICN').'<br/>';
        $hasError = true;
    }
    else{
        $lastname = $_POST['lastname'];
    }
    if ( trim( $_POST['email'] ) === '' ) {
        $error = _x('Please enter a email', 'theme','ICN').'<br/>';
        $hasError = true;
    }
    else{
        $email = $_POST['email'];
    }
    if ( ! isset($_POST['related_sdgs']) || ! $_POST['related_sdgs'] ) {
        $error = _x('Please select one/more related Goal', 'theme','ICN').'<br/>';
        $hasError = true;
    }
    else{
        $relatedsdgs = $_POST['related_sdgs'];
    }
    if ( trim( $_POST['casestudytitle'] ) === '' ) {
        $error = _x('Please enter a case study title', 'theme','ICN').'<br/>';
        $hasError = true;
    }
    else{
        $casestudytitle = $_POST['casestudytitle'];
    }
    if( trim($_POST['country']) ==='')
    {
        $error = _x('Please select a country', 'theme','ICN').'<br/>';
        $hasError = true;
    }
    else{
        $country = $_POST['country'];
    }

    //optional fields
    $title = $_POST['title'] ?: '';
    $position = $_POST['position'] ?: '';
    $institution = $_POST['institution'] ?: '';
    $extraInfo = $_POST['extrainfo'] ?: '';


    $goals = '';

    if ($relatedsdgs) {
        foreach ($relatedsdgs as $related_goal){
            $goal = get_post($related_goal);

            if ( $goal ) {
                $goals .= $goal->post_title;
                $goals .= ', ';
            }
        }
    }

    if(!$hasError) {


        //insert post

        $post_information = array(
            'post_title' => wp_strip_all_tags($_POST['casestudytitle']),
            'post_content' => $_POST['yourstory'],
            'post_type' => 'case_studies',
            'post_status' => 'pending'
        );

        $post_id = wp_insert_post($post_information);


        //add value to custom fields
        if($title) {
            update_field('title', $title, $post_id);
        }

        update_field('submit_by_first_name', $firstname, $post_id);
        update_field('submit_by_surname', $lastname, $post_id);
        if($position) {
            update_field('position', $position, $post_id);
        }
        if($institution) {
            update_field('institution', $institution, $post_id);
        }
        if($extraInfo)
        {
            update_field('submit_by', $extraInfo, $post_id);
        }
        update_field('email', $email, $post_id);
        update_field('country', $country, $post_id);
        update_field('related_goals', $relatedsdgs, $post_id);


        // insert image to media library
        if ($_FILES) {
            $files = $_FILES;

            if (is_array($files) && is_array($files['images']) && is_array($files['images']['name']) && count($files['images']['name']) && \ICN\Upload::countValidUploads($files['images']['name'])) { //They uploaded at least 1
                $images = $files['images'];
                $results = \ICN\Upload::uploadFilesToWordpress($images);

                if (array_key_exists('error', $results)) {
                    //Error!!!
                } else {
//                    $from = 'web@icnvoicetolead.com';
                    $from = 'ralph@acw.uk.com';
                    if($email_to)
                        $to = $email_to;
                    else
                        $to = 'ling@acw.uk.com';
                    $bcc = 'ling@acw.uk.com';
                    $subject = 'Case Study 2018 Website Submit - Share Your Story' . ' - ' . $date;
                    $post_url = get_edit_post_link($post_id);

                    $email_msg =
                        "<div style='font-family: Arial, Helvetica, sans-serif; font-size: 13px;'>
                            <strong>Submitted By</strong><br/>
                            Date submitted: $date<br/>
                            Title: $title<br/>
                            First Name: $firstname <br/>
                            Last Name: $lastname <br/>
                            Position: $position <br/>
                            Email: $email <br/><br/>
                            <strong>Case Study Details</strong><br/>
                            Case Study Title: $casestudytitle <br/>
                            Case Study Text: $casestudytxt <br/>
                            Country: $country <br/>
                            Related Goals: $goals <br/>
                            Extra Submmission Info: $extraInfo<br/><br/>
                            The post is pending for review, please view this <a href='$post_url'>post</a>, and <u>manually</u> add images.<br/>
                            Images: Please see the images in the email attachment<br/><br/><br/>
                            Via A Voice To Lead Website
                        </div>";

                    $attachments = [];

                    foreach ($results as $result) {
                        $attachments[] = $result['file'];
                    }

                    $email = \ICN\Upload::fireAttachmentEmail($from, $to, $subject, $email_msg, $attachments);

                    foreach ($results as $result) {
                        unlink($result['file']);
                    }
                }

            }


            //attach file and file email



            if ($post_id) {
                $thankyouMsg = '<div class="col-sm-12 alert-success" id="thankyouMessage">' .
                    _x('Thank you for submit your story with us, we will contact you if we require further information.', 'theme', 'ICN') .
                    '</div><div class="clr20"></div>';
                $form_status = 'hidden-xs-up';
            }
        }
    }
}

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
        <div class="masterheader parallax-window" data-parallax="scroll" data-image-src="<?=$feature_image; ?>"></div>
        <div class="container main-container <?=($feature_image)? : 'no_feature_image'?>">
            <div class="row">
                <div class="col-sm-12 col-md-10 offset-md-1">
                    <?= $hasError ? $error: ''; ?>
                    <?= $thankyouMsg ? $thankyouMsg: ''; ?>
                    <div class="page-content page-<?= $post->post_name; ?>">
                        <div class="content-entry">
                            <h1><?= ($long_title)? $long_title: $post->post_title ;?></h1>
                            <p><?php the_content(); ?></p>
                            <div class="clearfix"></div>
                            <form name="become_voice_to_lead" class="<?= $form_status; ?>" id="become_voice_to_lead" method="POST" enctype="multipart/form-data" action="<?= get_permalink(); ?>">
                                <div class="row">
                                    <div class="col-sm-12 col-md-2"><?php
                                        if($get_titles && is_array($get_titles) && array_key_exists('choices', $get_titles)): ?>
                                            <select class="form-control" name="title" id="title" required><option disabled selected><?= _x('Title','theme','ICN'); ?></option><?php
                                            foreach ($get_titles['choices'] as $person_title): ?>
                                                <option value="<?= $person_title; ?>"><?= $person_title; ?></option><?php
                                            endforeach; ?>
                                            </select><?php
                                        endif; ?>
                                    </div>
                                    <div class="col-sm-12 col-md-5">
                                        <input type="text" class="form-control" placeholder="<?= _x('First Name','theme','ICN'); ?>" id="firstname" name="firstname" value="<?php if ( isset( $_POST['firstname'] ) ) echo $_POST['firstname']; ?>" required>
                                    </div>
                                    <div class="col-sm-12 col-md-5">
                                        <input type="text" class="form-control" placeholder="<?= _x('Last Name','theme','ICN'); ?>" id="lastname" name="lastname" value="<?php if ( isset( $_POST['lastname'] ) ) echo $_POST['lastname']; ?>" required>
                                    </div>
                                    <div class="clr20"></div>
                                    <div class="col-sm-12 col-md-6">
                                        <input type="email" class="form-control" placeholder="<?= _x('Email','theme','ICN'); ?>" id="email" name="email" value="<?php if ( isset( $_POST['email'] ) ) echo $_POST['email']; ?>"  required>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <?php if($get_countries && is_array($get_countries) && array_key_exists('choices', $get_countries)): ?>
                                            <select class="form-control" name="country" required><option disabled selected><?= _x('Select a Country','theme','ICN'); ?></option><?php
                                            foreach ($get_countries['choices'] as $country): ?>
                                                <option value="<?= $country; ?>"><?= $country; ?></option><?php
                                            endforeach; ?>
                                            </select><?php
                                        endif; ?>
                                    </div>
                                    <div class="clr20"></div>
                                    <div class="col-sm-12 col-md-6">
                                        <input type="text" class="form-control" placeholder="<?= _x('Position','theme','ICN'); ?>" id="position" name="position" value="<?php if ( isset( $_POST['position'] ) ) echo $_POST['position']; ?>">
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <input type="text" class="form-control" placeholder="<?= _x('Institution','theme','ICN'); ?>" id="institution" name="institution" value="<?php if ( isset( $_POST['institution'] ) ) echo $_POST['institution']; ?>">
                                    </div>
                                    <div class="clr20"></div>
                                    <div class="col-sm-12 col-md-2 text-md-right">
                                        <label><?= _x('Related SDGs', 'theme', 'ICN');?></label>
                                    </div>
                                    <div class="col-sm-12 col-md-10">
                                        <select name="related_sdgs[]" id="related_sdgs" class="form-control" multiple required><?php
                                            if($get_goals):
                                                foreach ($get_goals as $goal): ?>
                                                    <option value="<?= $goal->ID; ?>"><?= $goal->post_title; ?></option><?php
                                                endforeach;
                                            endif; ?>
                                        </select>
                                        <small>(<?= _x('Hold Ctrl key to select multiple goals','theme','ICN'); ?>)</small>
                                    </div>
                                    <div class="clr20"></div>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" placeholder="<?= _x('Extra Submission Information','theme','ICN'); ?>" id="extrainfo" name="extrainfo" value="<?php if ( isset( $_POST['extrainfo'] ) ) echo $_POST['extrainfo']; ?>" maxlength="300"/>
                                    </div>
                                    <div class="clr20"></div>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" placeholder="<?= _x('Case Study Title','theme','ICN'); ?>" id="casestudytitle" name="casestudytitle" value="<?php if ( isset( $_POST['casestudytitle'] ) ) echo $_POST['casestudytitle']; ?>"  required>
                                    </div>
                                    <div class="clr20"></div>
                                    <div class="col-md-12">

                                        <textarea class="form-control" placeholder="<?= _x('Tell Us Your Story','theme','ICN'); ?>" id="yourstory" name="yourstory" rows="10" required onKeyDown="limitText(this.form.yourstory,this.form.countdown,1000);"
                                                  onKeyUp="limitText(this.form.yourstory,this.form.countdown,1000);" minlength="100" maxlength="1000"> <?php if ( isset( $_POST['yourstory'] ) ) { if ( function_exists( 'stripslashes' ) ) { echo stripslashes( $_POST['yourstory'] ); } else { echo $_POST['yourstory']; } } ?></textarea>
                                        <small>(Maximum characters: 1000)<br>
                                            You have <input readonly type="text" name="countdown" size="4" value="1000"> characters left.</small>
                                    </div>
                                    <div class="clr20"></div>
                                    <div class="col-md-12">
                                        <label><?= _x('Upload Images','theme','ICN'); ?> </label></a>
                                        <div class="clr5"></div>
                                        <small>(please only upload image in gif, jpg or png format, the maximum size of the image is 2M)</small>
                                        <div class="clr5"></div>
                                        <input type="file" class="share_your_story_upload" name="images[]" accept="image/gif,image/jpg,image/jpeg,image/png" />
                                        <div class="clr10"></div>
                                        <input type="file" class="share_your_story_upload" name="images[]" accept="image/gif,image/jpg,image/jpeg,image/png" />
                                        <div class="clr10"></div>
                                        <input type="file" class="share_your_story_upload" name="images[]" accept="image/gif,image/jpg,image/jpeg,image/png" />

                                    </div>
                                    <div class="clr20"></div>
                                    <div class="col-md-12">
                                        <div class="g-recaptcha" data-sitekey="6Lf91R4UAAAAAFNLWL_bMYYd5KnKjsPzppkgsa9S" data-callback="enableSubmit"></div>
                                        <input type="hidden" name="submitted" id="submitted" value="true" />
                                        <?php //wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>

                                    </div>
                                    <div class="clr20"></div>
                                    <div class="col-sm-12 text-xs-center text-sm-center text-md-right">
                                        <button type="submit" name="submit_case_study" class="icn-btn" id="submit_case_study"><?= _x('Submit','theme','ICN'); ?></button>
                                    </div>


                                </div>
                            </form>
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
    var submitBtn = document.getElementById("submit_case_study");

    if ( submitBtn )
        submitBtn.disabled = true;

    function enableSubmit() {
        if ( submitBtn )
            submitBtn.disabled = false;
    }
</script>
