<?php header("Content-Language: ". $language['active']); ?><!doctype html>
<html ⚡ lang="<?php echo $language['active']; ?>">
  <head>

    <!-- Load AMP -->
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <?php if ($the_gtm_id_amp != '') { ?>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <?php } ?>
    <?php if ($amp_cookie_consent) { ?>
    <script async custom-element="amp-geo" src="https://cdn.ampproject.org/v0/amp-geo-0.1.js"></script>
    <script async custom-element="amp-consent" src="https://cdn.ampproject.org/v0/amp-consent-0.1.js"></script>
    <?php } ?>

    <!-- General Meta -->
    <?php include_once './templates/general_meta.php'; ?>

    <!-- CSS -->
    <!-- Needs to be inline at AMP pages! -->
    <style amp-custom>
      <?php
      // Mind to not have any relative URLs in your stylesheet. If so, you can use the str_replace here. Otherwise, just include it.
      $stylesheetForAMP = file_get_contents('./assets/css/style.min.css');
      echo str_replace('../fonts/',rtrim($the_page_url, '/') . '/assets/fonts/',$stylesheetForAMP);
      // include_once './assets/css/style.min.css';
      include_once './assets/css/style_amp.min.css';
      ?>
    </style>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
  
  </head>
  <body itemscope itemtype="http://schema.org/WebSite">

    <!-- Cookie Consent -->
    <?php
    if ($amp_cookie_consent) include_once './templates/cookie_consent_amp.php';
    ?>

    <!-- Google Tag Manager for AMP -->
    <?php
    if ($the_gtm_id_amp != '') {
      echo '<amp-analytics config="https://www.googletagmanager.com/amp.json?id=' . $the_gtm_id_amp . '&gtm.url=SOURCE_URL" data-credentials="include" ';
      if ($amp_cookie_consent) echo 'data-block-on-consent';
      echo '></amp-analytics>';
    }
    ?>

    <link itemprop="url" href="<?php echo $the_page_url_full; ?>"/>
    <div id="main">

