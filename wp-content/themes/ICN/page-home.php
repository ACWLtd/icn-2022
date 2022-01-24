<?php
/**
 ** Home Page Template (All languages )
 *  Template Name: Page - Home Page
 */
global $post;
get_header();
$home_sections = get_field('home_section');
$FBfeeds = getFacebookFeed();
$fb_lnk = get_field('facebook_link','option');
$tw_lnk = get_field('twitter_link','option');
$launchDate = new DateTime('2017-05-11 23:59:59');
$now = new DateTime();
$showCountdown = $now < $launchDate;  ?>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v5.0&appId=256039104931333&autoLogAppEvents=1"></script>
<div id="home"><?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <!-- count down section -->
            <section id="home-countdown">

                <div class="wrapper"><?php
//                    if ( $showCountdown ) : ?>
<!--                        <div class="row row-coundown hidden-sm-down">-->
<!--                            <div class="col-xs-12 col-countdown text-xs-center">-->
<!--                                <div id="countdown-panel">-->
<!--                                    <div class="row">-->
<!--                                        <h2 class="text-uppercase">countdown to the international nurses' day</h2>-->
<!--                                        <div class="clr30"></div>-->
<!--                                        <div class="col-xs-4 col-sm-4 text-sm-center">-->
<!--                                            <div id="cd-m" class="cd-figure"></div>-->
<!--                                            <div class="clr10"></div>-->
<!--                                            <span>Months</span>-->
<!--                                        </div>-->
<!--                                        <div class="col-xs-4 col-sm-4 text-sm-center">-->
<!--                                            <div id="cd-d" class="cd-figure"></div>-->
<!--                                            <div class="clr10"></div>-->
<!--                                            <span>Days</span>-->
<!--                                        </div>-->
<!--                                        <div class="col-xs-4 col-sm-4 text-sm-center">-->
<!--                                            <div id="cd-h" class="cd-figure"></div>-->
<!--                                            <div class="clr10"></div>-->
<!--                                            <span>Hours</span>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>--><?php
//                        endif ?>
                    <div class="container-fluid h-100">
                        <div class="row h-100 hero-section">
                            <?php
                            $hero = get_field('home_hero');

                            if( $hero ):?>
                                <div class="col-sm-12 col-md-12 hero-bg-image image-home-bg" style="padding:0;">
                                    <img src="<?php echo  $hero; ?>" alt="image-home-bg">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row row-background no-spacing">
                        <div class="col-sm-12 col-md-6 col-left">
<!--                            <div class="col-md-12 text-sm-center text-md-right col-txt">-->
<!--                                <img src="--><?//= get_template_directory_uri(); ?><!--/assets/img/many_stories.png" alt=Many Stories""/>-->
<!--                            </div>-->
                        <div id="homefafeed" class="lastfeed hidden-sm-down"><?php
                            if($FBfeeds):
                                $latestFB = $FBfeeds['data'][0];
                                $latestFBId = explode("_", $latestFB['id']);
                                $latestFBTimestamp = strtotime($latestFB['created_time']);
                                $latestFBDate = date("j F, Y", $latestFBTimestamp);
                                $userId = $latestFBId[0];
                                $latestPostId = $latestFBId[1];
                                $latest_url ='https://www.facebook.com/icn.ch/posts/'.$latestPostId; ?>

                                <ul>
                                    <li><a href="<?= $fb_lnk; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><?= $latestFBDate; ?></li>
                                    <li><a href="<?= $latest_url; ?>" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i></a>&nbsp;&nbsp;</li><?php
                                        if (!empty($latestFB['message'])):
                                            echo "<li>". $latestFB['message']."</li>";
                                        else:
                                            echo "<li>".$latestFB['story']."</li>";
                                        endif;
                                        endif; ?>
                                </ul>

                        </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-right">
<!--                            <div class="col-md-12 text-sm-center text-md-left col-txt">-->
<!--                                <img src="--><?//= get_template_directory_uri(); ?><!--/assets/img/many_voices.png" alt=Many Voices""/>-->
<!--                            </div>-->
                            <div id="hometwfeed" class="lastfeed hidden-sm-down">
                                <a href="<?= $tw_lnk; ?>" target="_blank" class="toleft"><i class="fa fa-twitter" aria-hidden="true"></i>&nbsp;&nbsp;</a>
                                <div id="hometwfeed_data" class="toleft"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- //count down section --><?php
            if($home_sections):
                foreach ($home_sections as $key=>$home_section):
                    $section_page = $home_section['section_page'];
                    $section_title = $home_section['home_section_name'];
                    $section_bg_url = $home_section['home_section_background'];
                    $section_summary = $home_section['home_section_summary'];
                    ?>
                    <section id="<?= $section_page->post_name; ?>" class="home-section home-section-<?php echo $key?>" style="background-image: url(<?=$section_bg_url; ?>);">
                        <div class="content-panel col-sm-12 col-md-10 <?= ($key%2!=0)? '':'offset-md-2';?> col-lg-5 <?= ($key%2!=0)? '':'offset-lg-7';?>">
                            <div class="floating-square-<?php echo $key?>"></div>
                            <h3><?= $section_title; ?></h3>
                            <?=$section_summary; ?>
                            <a href="<?= get_permalink($section_page->ID); ?>" title="<?=$section_page->page_title; ?>" class="icn-btn toright"><?= _x('Read More', 'theme','ICN'); ?></a>
                        </div>
                    </section><?php
                endforeach;
            endif; ?>
<!--            <div id="video-container">-->
<!--                <div class="container">-->
<!--                    <div class="row row-video-wrapper">-->
<!--                        <div class="col-sm-12 col-md-8 offset-md-2 text-sm-center">-->
<!--                            <div class="clr50"></div>-->
<!--                            <h3>--><?//= _x("Become a Voice to Lead Video", "theme","ICN"); ?><!--</h3>-->
<!--                            <video style="width:100%; height: auto" controlsList="nodownload" controls>-->
<!--                                <source src="--><?//= get_site_url(); ?><!--/wp-content/uploads/2017/05/ICN.mp4"-->
<!--                                        type='video/mp4;codecs="avc1.42E01E, mp4a.40.2"'/>-->
<!--                            </video>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--            </div>-->
            <div id="soical-feeds-container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="hashtag"><strong>#VoiceToLead #IND2021</strong></label>
                            <div class="clr50"></div>
                            <div class="mb-5 text-center">
                                <?php the_content(); ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 text-md-center">
                                    <h4>FACEBOOK</h4>
                                    <h5 style="text-transform: uppercase;">follow @icn.ch on facebook</h5>
                                    <div class="fb-page" data-href="https://www.facebook.com/icn.ch/" data-tabs="timeline" data-width="400" data-height="800" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                        <blockquote cite="https://www.facebook.com/icn.ch/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/icn.ch/">ICN - International Council of Nurses</a></blockquote>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 text-md-center social-tw">
                                    <h4>TWITTER</h4>
                                    <h5 style="text-transform: uppercase;">follow @icnurses on twitter</h5>
<!--                                    <div id="twitterfeed"></div>-->
                                    <a class="twitter-timeline" data-height="800" href="https://twitter.com/ICNurses">Tweets by ICNurses</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div><?php
        endwhile;
    else :
        get_template_part('template-parts/content', 'none');
    endif; ?>
</div><!-- /#home --><?php
get_footer(); ?>
<script>
    $(function () {
        //get twitter feed
        var latesttwitterConfig = {
            "profile" : {"screenName":'icnurses'},
            "domId": 'bottomtwfeed',
            "maxTweets": 1,
            "enableLinks": true,
            "showUser": false,
            "showTime": true,
            "showImages": false,
            "showRetweet": false,
            "customCallback": getLatestTweet
        };

        function getLatestTweet(tweets){
            var x = tweets.length;
            var n = 0;
            var element = document.getElementById('hometwfeed_data');
            var html = '';
            while(n < x) {
                html += tweets[n];
                n++;
            }
            html += '</ul>';
            element.innerHTML = html;
        }
        twitterFetcher.fetch(latesttwitterConfig);

        var twitterConfig= {
            "profile" : {"screenName":'icnurses'},
            "domId": 'twitterfeed',
            "maxTweets": 5,
            "enableLinks": true,
            "showUser": false,
            "showTime": true,
            "showImages": false,
            "showRetweet": false,
            "customCallback": handleTweets
        };

        function handleTweets(tweets){
            var x = tweets.length;
            var n = 0;
            var element = document.getElementById('twitterfeed');
            var html = '<ul>';
            while(n < x) {
                html += '<li><div class="tweetdata" id="twdata-'+n+'">' + tweets[n] + '</div></li>';
                n++;
            }
            html += '</ul>';
            element.innerHTML = html;
        }


        twitterFetcher.fetch(twitterConfig);


        $( ".lastfeed" )
            .mouseenter(function() {
                $(this).stop().animate({height:'110px'}, 500);
            })
            .mouseleave(function() {
                $(this).stop().animate({height:'26px'}, 500);
            });

    });
</script>



