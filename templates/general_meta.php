<!-- General Meta Information -->
<!-- Content generates from config.php. Only adjust if you need to add, change, or remove complete functionalities. -->

<!-- Descriptive Meta -->
<title><?php echo $the_page->title; ?></title>
<meta name="author" content="<?php echo $the_page->author; ?>">
<meta name="publisher" content="<?php echo $the_page->publisher; ?>">
<meta name="keywords" content="<?php echo $the_page->keywords; ?>">
<meta name="description" content="<?php echo $the_page->description; ?>">

<!-- Crawler Meta -->
<meta name="robots" content="<?php echo $the_page->robots; ?>">
<link rel="canonical" href="<?php echo $current_url; ?>">

<!-- Multilanguage Meta -->
<?php
foreach ($language['available'] as $lang => $lang_name) {
  if (isset($pages[$lang][$the_page->id])) {
    $language_url = $the_page_url;
    if ($lang != $language['default']) $language_url .= $lang . '/';
    if ($the_page->slug != 'main') {
      if (isset($pages[$lang][$the_page->id]['slug']) and $pages[$lang][$the_page->id]['slug'] != '') {
        $language_url .= $pages[$lang][$the_page->id]['slug'] . '/';
      } else {
        $language_url .= $the_page->id . '/';
      }
    }
    echo '<link rel="alternate" href="' . $language_url . '" hreflang="' . $lang . '">';
    if ($lang == $language['default']) echo '<link rel="alternate" href="' . $language_url . '" hreflang="x-default">';
  }
}
?>

<!-- Tech Meta -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">

<!-- Social Media Information -->
<!-- Open Graph (https://ogp.me/) -->
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo $the_page->title; ?>">
<meta property="og:site_name" content="<?php echo $the_webapp_name; ?>">
<meta property="og:description" content="<?php echo $the_page->description; ?>">
<meta property="og:image" content="<?php echo $the_page_url; ?>assets/images/social_media.png">
<!-- Twitter (https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/markup) -->
<?php if ($the_page->twitter != '') { ?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="<?php echo $the_page_url; ?>"> <!-- use URL or Twitter username here -->
<meta name="twitter:creator" content="<?php echo $the_page->twitter; ?>">
<meta name="twitter:title" content="<?php echo $the_page->title; ?>">
<meta name="twitter:description" content="<?php echo $the_page->description; ?>">
<meta name="twitter:image" content="<?php echo $the_page_url; ?>assets/images/social_media.png">
<?php } ?>

<!-- Favicons -->
<!-- Mind to also adjust webmanifest and browserconfig.xml ! -->
<!-- Generate your favicon set via https://realfavicongenerator.net/ -->
<!-- Mind to not only exchange the favicons in /assets/favicons, but also the favicon.ico at root level! -->
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $the_page_url; ?>assets/favicons/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $the_page_url; ?>assets/favicons/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $the_page_url; ?>assets/favicons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $the_page_url; ?>assets/favicons/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $the_page_url; ?>assets/favicons/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $the_page_url; ?>assets/favicons/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $the_page_url; ?>assets/favicons/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $the_page_url; ?>assets/favicons/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $the_page_url; ?>assets/favicons/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $the_page_url; ?>assets/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $the_page_url; ?>assets/favicons/favicon-16x16.png">
<link rel="mask-icon" href="<?php echo $the_page_url; ?>assets/favicons/safari-pinned-tab.svg" color="#323032">
<link rel="shortcut icon" href="<?php echo $the_page_url; ?>assets/favicons/favicon.ico">
<meta name="msapplication-TileColor" content="<?php echo $the_theme_color; ?>">
<meta name="msapplication-TileImage" content="<?php echo $the_page_url; ?>assets/favicons/mstile-144x144.png">
<meta name="msapplication-config" content="<?php echo $the_page_url; ?>assets/favicons/browserconfig.xml">

<!-- PWA Meta -->
<?php if ($the_webapp_status) { ?>
<meta name="mobile-web-app-capable" content="yes">
<link rel="manifest" href="<?php echo $the_page_url; ?>manifest.json" crossOrigin="use-credentials">
<meta name="theme-color" content="<?php echo $the_theme_color; ?>">
<meta name="apple-mobile-web-app-title" content="<?php echo $the_webapp_name; ?>">
<meta name="application-name" content="<?php echo $the_webapp_name; ?>">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php } ?>
