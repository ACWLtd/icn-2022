<?php
$fb_lnk = get_field('facebook_link','option');
$tw_lnk = get_field('twitter_link','option');
$ln_lnk = get_field('linkedin_link','option'); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-skrollr">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?= get_template_directory_uri(); ?>/assets/img/apple-touch-icon-120x120.png" />
    <link rel="icon" type="image/png" href="<?= get_template_directory_uri(); ?>/assets/img/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="<?= get_template_directory_uri(); ?>/assets/imgfavicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?= get_template_directory_uri(); ?>/assets/img/favicon-16x16.png" sizes="16x16" /><?php
    wp_head(); ?>

    <!-- GDPR Banner Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tarteaucitronjs/1.9.3/tarteaucitron.js"
        integrity="sha512-cL0fC89w+H+0KjI9fD6dnM4IHyiapz9tpd9x6SarmL/O4xEGPKBepxZdm0rZXliYplhVQ30DHczX6+mttFm71Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>

    <!-- GDPR Banner settings -->
    <script type="text/javascript">
        tarteaucitron.init({
            "privacyUrl":  "<?= get_stylesheet_directory_uri() ?>/assets/doc/icn_privacy_policy_en.pdf", /* Privacy policy url */
            "hashtag": "#icn2021", /* Open the panel with this hashtag */
            "cookieName": "icn2021", /* Cookie name */
            "orientation": "bottom", /* Banner position (top - bottom) */
            "groupServices": false, /* Group services by category */
            "showAlertSmall": false, /* Show the small banner on bottom right */
            "cookieslist": true, /* Show the cookie list */
            "closePopup": false, /* Show a close X on the banner */
            "showIcon": true, /* Show cookie icon to manage cookies */
            "iconSrc": "<?= get_stylesheet_directory_uri() ?>/assets/img/ICN_main_logo.png", /* Optionnal: URL or base64 encoded image */
            "iconPosition": "BottomRight", /* BottomRight, BottomLeft, TopRight and TopLeft */
            "adblocker": false, /* Show a Warning if an adblocker is detected */
            "DenyAllCta" : true, /* Show the deny all button */
            "AcceptAllCta" : true, /* Show the accept all button when highPrivacy on */
            "highPrivacy": true, /* HIGHLY RECOMMANDED Disable auto consent */
            "handleBrowserDNTRequest": false, /* If Do Not Track == 1, disallow all */
            "removeCredit": true, /* Remove credit link */
            "moreInfoLink": true, /* Show more info link */
            "useExternalCss": false, /* If false, the tarteaucitron.css file will be loaded */
            "useExternalJs": false, /* If false, the tarteaucitron.js file will be loaded */
            //"cookieDomain": ".my-multisite-domaine.fr", /* Shared cookie for multisite */
            "readmoreLink": "", /* Change the default readmore link */
            "mandatory": true, /* Show a message about mandatory cookies */
            });
    </script>

    <script type="text/javascript">
        tarteaucitron.user.gtagUa = 'UA-98468824-1';
        // tarteaucitron.user.gtagCrossdomain = ['example.com', 'example2.com'];
        tarteaucitron.user.gtagMore = function () { /* add here your optionnal gtag() */ };
        (tarteaucitron.job = tarteaucitron.job || []).push('gtag');
    </script>


</head>
<body <?php body_class(); ?>>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.11&appId=402910206808338";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <header>
        <div class="container">
            <div class="row row-header">
                <div class="col-xs-11 col-sm-12 text-xs-center text-sm-center col-md-5 col-lg-5 col-xl-4 col-logo">
                    <a href="<?= get_site_url(); ?>"  title="<?= get_bloginfo(); ?>"><img class="logo-header" src="<?= get_template_directory_uri(); ?>/assets/img/landing/ICN_Logo_2021.png" class="logo-main img-fluid" alt="<?= get_bloginfo(); ?>"/></a>
                </div>
                <div class="col-xs-12 col-sm-12 text-xs-center text-sm-center col-md-6 col-lg-6 col-xl-8 col-nav">
                    <div class="row">
                        <div class="col-lg-12 col-xl-9 text-md-right">
                            <a href="http://www.icn.ch/" target="_blank"><img src="<?= get_template_directory_uri(); ?>/assets/img/ICN_top_logo_2.jpg" class="logo-inline" alt="<?= get_bloginfo(); ?>"/></a>
                        </div>
                        <div style="padding-left: 0; padding-right: 0;" class="col-lg-12 col-xl-3">
                            <ul class="top_social_lnks">
                                <li id="show_small_search_div">
                                    <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
                                        <input type="search" class="search-field" placeholder="Search …" value="" name="s" autocomplete="on"/>
                                        <input type="submit" class="search-submit" value="Search" id="search_submit"/></button>
                                    </form>
                                </li><?php
                                if($fb_lnk): ?>
                                    <li><a href="<?= $fb_lnk; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li><?php
                                endif;
                                if ($tw_lnk): ?>
                                    <li><a href="<?= $tw_lnk; ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li><?php
                                endif;
                                if ($tw_lnk): ?>
                                    <li><a href="<?= $ln_lnk; ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li><?php
                                endif; ?>
                                <li>&nbsp;</li>
                                <li><a href="https://icnvoicetolead.com/"><i style="font-size: 17px;position: absolute;top: 14px;" class="fa fa-home" aria-hidden="true"></i></a></li>
                            </ul>

                        </div>
                        <div class="col-md-12 col-lg-1">
                            <?php //icn_language_switcher(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 py-3">
                            <?php
                            wp_nav_menu( array(
                                'menu' => 'Main Menu',
                                'menu_id'=> 'main-nav',
                                'menu_class' => 'main-nav text-md-right hidden-lg-down',
                                'container_id' => 'main-nav-wrapper',
                                'depth' => 2
                            )); ?>
                        </div>
                    </div>

                </div>
                <div class="clearfix"></div>

                <nav class="hidden-xl-up">
                    <a id="nav-close" class="toright"><i class="fa fa-times"></i></a>
                    <?php
                    wp_nav_menu( array(
                        'menu' => 'Main Menu',
                        'menu_id'=> 'mobile-main-nav',
                        'menu_class' => 'list-unstyled slideout-menu',
                        'depth' => 2
                    )); ?>
                </nav>
                <div class="col-md-12 navbar-inverse navbar-fixed-top hidden-xl-up mobile-nav-icon toright">
                    <!--Include your brand here-->
                    <div class="navbar-header pull-right">
                        <a id="nav-expander" class="nav-expander fixed">
                            <i class="fa fa-bars fa-lg white"></i>
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </header>
