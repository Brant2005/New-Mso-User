<?php include "../functions.php"; ?>
<!DOCTYPE html>
<!--
     ____ _  __ __  __ __ __ ____
    /  _// |/ // / / // //_// __ \
   _/ / /    // /_/ // ,<  / /_/ /
  /___//_/|_/ \____//_/|_| \____/

-->
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <meta name="format-detection" content="telphone=no,email=no">
    <meta name="keywords" content="MSO, Office, 365, 犬, 狗子, 小白-白">
    <meta name="description" content="MSO 账号兑换平台">
    <meta name="cdn" content="<?php echo $RESURL; ?>">
    <meta name="author" content="Moedog">
    <title>MSO 365 Application</title>
    <link href="<?php echo $RESURL; ?>/static/css/main.min.css" rel="stylesheet">
    <link href="<?php echo $RESURL; ?>/static/favicon.ico" rel="shortcut icon">
  </head>
  <body data-go="<?php if(getParam("key")) echo "key"; ?>">
    <div id="home-slider">
        <div class="preloader">
            <svg width="60" height="60" fill="#0099ae" viewBox="0 0 2048 2048" xmlns="http://www.w3.org/2000/svg">
                <path d="M1600 1024q0-117-45.5-223.5t-123-184-184-123-223.5-45.5-223.5 45.5-184 123-123 184-45.5 223.5 45.5 223.5 123 184 184 123 223.5 45.5 223.5-45.5 184-123 123-184 45.5-223.5zm276 277q-4 15-20 20l-292 96v306q0 16-13 26-15 10-29 4l-292-94-180 248q-10 13-26 13t-26-13l-180-248-292 94q-14 6-29-4-13-10-13-26v-306l-292-96q-16-5-20-20-5-17 4-29l180-248-180-248q-9-13-4-29 4-15 20-20l292-96v-306q0-16 13-26 15-10 29-4l292 94 180-248q9-12 26-12t26 12l180 248 292-94q14-6 29 4 13 10 13 26v306l292 96q16 5 20 20 5 16-4 29l-180 248 180 248q9 12 4 29z"/>
            </svg>
        </div>
        <div class="container">
            <div class="main-slider">
                <div class="slide-text">
                    <h1>在开始之前...</h1>
                    <p>请注意：如果您不知道此站点是干什么的，请点击浏览器的关闭按钮。</p>
                    <p>如果您拥有兑换码，请点击下面的“开始”按钮。</p>
                    <a href="javascript:;" class="btn start" data-form="<?php echo $LOCALURL."/form.php";if(getParam("key")) echo "?key=".getParam("key"); ?>">开始</a>
                    <a href="javascript:;" class="btn about">关于</a>
                </div>
                <img src="<?php echo $RESURL; ?>/static/images/hill.png" class="slider-hill">
                <img src="<?php echo $RESURL; ?>/static/images/house.png" class="slider-house">
                <img src="<?php echo $RESURL; ?>/static/images/sun.png" class="slider-sun">
                <img src="<?php echo $RESURL; ?>/static/images/birds1.png" class="slider-birds1">
                <img src="<?php echo $RESURL; ?>/static/images/birds2.png" class="slider-birds2">
            </div>
        </div>
    </div>
    <script src="<?php echo $RESURL; ?>/static/js/jquery.min.js"></script>
    <script src="<?php echo $RESURL; ?>/static/js/main.min.js"></script>
  </body>
</html>