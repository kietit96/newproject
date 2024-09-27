<style type="text/css">
  <?php if($config->blockCopy == '1'){ ?>
  body{-moz-user-select:none!important;-webkit-touch-callout:none!important;-webkit-user-select:none!important;-khtml-user-select:none!important;-moz-user-select:none!important;-ms-user-select:none!important;user-select:none!important}
  <?php } ?>

  #infoPage{display:none}
  #scrollPage{position:fixed;right:10px;bottom:40px;z-index:999;display:none;}
  .iconFixed{border:solid 1px #ccc;padding:9px 10px 9px 32px;width:0;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;-webkit-transition:all .5s;-moz-transition:all .5s;transition:all .5s}
  .shopFixed{right:5px;top:110px}
  .phoneFixed a{color:#fff;font-size:20px;}
  .phoneFixed{position:fixed;z-index:9999;border-radius:5px;bottom:1%;left:1%;min-width:50px}
  input{outline:none}
  .btn-default{color:white;}
  input:-moz-placeholder{color:#999}
  input::-webkit-input-placeholder{color:#999}
  .contentAjax,.contentAjax img{max-width:100%;}
  .divider-new{ display: none; }
</style>

<script type="text/javascript">
  navigator.userAgent.indexOf("Speed Insights")==-1&&(!function(a,b,c){var d,e=a.getElementsByTagName(b)[0];a.getElementById(c)||(d=a.createElement(b),d.id=c,d.src="//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6&appId=174220409684186",e.parentNode.insertBefore(d,e))}(document,"script","facebook-jssdk"),function(a,b,c,d,e,f,g){a.GoogleAnalyticsObject=e,a[e]=a[e]||function(){(a[e].q=a[e].q||[]).push(arguments)},a[e].l=1*new Date,f=b.createElement(c),g=b.getElementsByTagName(c)[0],f.async=1,f.src=d,g.parentNode.insertBefore(f,g)}(window,document,"script","http://www.google-analytics.com/analytics.js","ga"),ga("create","UA-58262430-2","auto"),ga("send","pageview")),$(window).scroll(function(){$(this).scrollTop()?$("#scrollPage:hidden").stop(!0,!0).fadeIn():$("#scrollPage").stop(!0,!0).fadeOut()});
</script>

<?php if($config->showPhoneFixed){ ?>
<div class="phoneFixed">
    <a class="btn btn-primary" href="tel:<?=$infoPage->phone?>">
        <i class="fa fa-phone"></i> Hotline: 
        <?=$infoPage->phone?>
    </a>
</div>
<?php } ?>

<div id="scrollPage" >
  <button id="#backTop" onclick="goToTop();" class="btn btn-danger btn-sm">
    <i class="fa fa-angle-up fa-2x"></i>
  </button>
</div>