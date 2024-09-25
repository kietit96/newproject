<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi" data-load="<?= $menuPage->name ?>">
<!-- THE CODE REWRITE BY HTTPS://FB.ME/GTFAF -->

<head>
    <base href="<?= baseUrl ?>" data-url="<?= baseUrl ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" type="image/x-icon" href="upload/<?= $infoPage->icon ?>" />
    <title><?= $title ?></title>
    <meta name="title" content="<?= $title ?>" />
    <meta name="description" content="<?= $des ?>" />
    <meta name="keywords" content="<?= $keywords ?>" />
    <meta name="robots" content="noodp,index,follow" />
    <meta name="revisit-after" content="1 days" />
    <?php if ($config->notMobile == 0) { ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php } else { ?>
        <meta name="viewport" content="width=1024, initial-scale=1" />
    <?php } ?>
    <meta property="og:title" content="<?= $title ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:url" content="<?= pageUrl() ?>" />
    <meta property="og:image" content="<?= baseUrl . 'upload/' . $image ?>" />
    <meta property="og:thumbnail" content="<?= baseUrl . 'upload/' . $image ?>" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />
    <meta property="og:description" content="<?= $des ?>" />
    <meta property="fb:app_id" content="174220409684186" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="<?= $des ?>" />
    <meta name="twitter:title" content="<?= $title ?>" />
    <meta name="twitter:image" content="<?= baseUrl . 'upload/' . $image ?>" />
    <meta name="twitter:creator" content="@_gtfaf" />

    <meta name="google-site-verification" content="<?= $infoPage->googleVerification ?>" />
    <link rel="canonical" href="<?= pageUrl() ?>">
    <link rel="dns-prefetch" href="<?= pageUrl() ?>">
    <!-- <script type="text/javascript" src="admin/plugins/jQuery/jQuery-2.1.4.min.js"></script> -->
    <script type="text/javascript" src="views/template/js/jquery-3.1.1.min.js"></script>
    <!-- fontawesome 5 -->
    <link rel="stylesheet" type="text/css" href="admin/plugins/fontawesome-5.15.4/css/all.min.css" />
    <!-- fontawesome 4 -->
    <!-- <link rel="stylesheet" type="text/css" href="admin/plugins/font-awesome/css/font-awesome.min.css" /> -->

    <link rel="stylesheet" type="text/css" href="admin/new-template/tinymce/tinymce/content.css">

    <!-- <link rel="stylesheet" type="text/css" href="admin/plugins/bootstrap/css/bootstrap.min.css" />
    <script defer type="text/javascript" src="admin/plugins/bootstrap/js/bootstrap.min.js"></script> -->

    <!-- <link rel="stylesheet" type="text/css" href="admin/plugins/simplyscroll/jquery.simplyscroll.css"/>
    <script defer type="text/javascript" src="admin/plugins/simplyscroll/jquery.simplyscroll.js"></script> -->

    <link rel="stylesheet" type="text/css" media="screen" href="admin/plugins/fancybox-3.5.7/dist/jquery.fancybox.min.css"/>
    <script defer type="text/javascript" src="admin/plugins/fancybox-3.5.7/dist/jquery.fancybox.min.js"></script>

    <link rel="stylesheet" type="text/css" href="admin/new-template/owlcarousel/assets/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="admin/new-template/owlcarousel/assets/owl.theme.default.min.css" />
    <script defer type="text/javascript" src="admin/new-template/owlcarousel/owl.carousel.min.js"></script>

    <script defer type="text/javascript" src="admin/plugins/nprogress/nprogress.js"></script>
    <link rel="stylesheet" type="text/css" href="admin/plugins/nprogress/nprogress.css" />

    <link rel="stylesheet" type="text/css" href="admin/plugins/bootstrap-dropdown/css/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="admin/plugins/bootstrap-dropdown/css/bootstrap-dropdownhover.min.css" />
    <script defer type="text/javascript" src="admin/plugins/bootstrap-dropdown/js/bootstrap-dropdownhover.min.js"></script>

    <!-- <link rel="stylesheet" type="text/css" href="admin/plugins/wow/animate.min.css" /> -->
    <script defer type="text/javascript" src="admin/plugins/wow/wow.min.js"></script>
    <script defer type="text/javascript" src="admin/assets/js/custom.js"></script>

    <!--mmenu-->
    <link rel="stylesheet" href="admin/plugins/mmenu-js-master/dist/mmenu.css">
    <script defer type="text/javascript" src="admin/plugins/mmenu-js-master/dist/mmenu.js"></script>

    <!--flatpickr picktime-->
    <link rel="stylesheet" href="admin/plugins/flatpickr/dist/flatpickr.min.css">
    <script defer type="text/javascript" src="admin/plugins/flatpickr/dist/flatpickr.min.js"></script>

    <div id="fb-root"></div>
    <address class="vcard" style="display:none">
        <img <?= srcLogo($infoPage, 'logo') ?> class="photo" />
        <a class="url fn" href="<?= baseUrl ?>"><?= $infoPage->title ?></a>
        <div class="org"><?= $infoPage->title ?> Co, Ltd</div>
        <div class="adr">
            <div class="street-address"><?= $infoPage->address ?></div>
            <span class="locality">Ho Chi Minh</span>,
            <span class="region">Binh Thanh</span>
            <span class="postal-code">70000</span>
        </div>
        <div class="tel"><?= $infoPage->phone ?></div>
    </address>
    <div itemtype="http://schema.org/website ">
        <div itemtype="http://schema.org/website" itemscope="">
            <div><span itemprop="keywords"><a rel="tag" href="<?= baseUrl ?>"></a></span></div>
        </div>
    </div>
    <!-- <script>
        jQuery(document).ready(function() {
            jQuery(function() {
                jQuery(this).bind("contextmenu", function(event) {
                    event.preventDefault();
                  
                });
            });
            (function() {
                'use strict';
                let style = document.createElement('style');
                style.innerHTML = '*{ user-select: none !important; }';

                document.body.appendChild(style);
            })();
            window.onload = function() {
                document.addEventListener("contextmenu", function(e) {
                    e.preventDefault();
                }, false);
                document.addEventListener("keydown", function(e) {

                    if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                        disabledEvent(e);
                    }

                    if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                        disabledEvent(e);
                    }

                    if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                        disabledEvent(e);
                    }

                    if (e.ctrlKey && e.keyCode == 85) {
                        disabledEvent(e);
                    }

                    if (event.keyCode == 123) {
                        disabledEvent(e);
                    }
                }, false);

                function disabledEvent(e) {
                    if (e.stopPropagation) {
                        e.stopPropagation();
                    } else if (window.event) {
                        window.event.cancelBubble = true;
                    }
                    e.preventDefault();
                    return false;
                }
            }
        });
    </script>
    <style>
        body {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }
    </style> -->
</head>