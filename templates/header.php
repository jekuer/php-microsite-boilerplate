<?php header("Content-Language: ". $language['active']); ?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $language['active']; ?>" xml:lang="<?php echo $language['active']; ?>">
  <head>

    <!-- Google Tag Manager -->
    <!-- Any Cookie Consent solution is recommended to be included via the GTM. -->
    <?php
    if ($the_gtm_id != '') {
      echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','" . $the_gtm_id . "');</script>";
    }
    ?>

    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    <!-- Service Worker Cache -->
    <script>
      if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
          navigator.serviceWorker.register(<?php echo "'" . $the_page_url . "serviceworker-cache.min.js?v=" . $version_nr . "'"; ?>).then(function(registration) {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
          }, function(err) {
            console.log('ServiceWorker registration failed: ', err);
          });
        });
      }
    </script>

    <!-- General Meta -->
    <base href="<?php echo $the_page_url; ?>">
    <?php include_once './templates/general_meta.php'; ?>

    <!-- Preconnect to other servers/domains -->
    <?php
    if ($the_gtm_id != '') {
      echo '<link rel="preconnect" href="https:///www.googletagmanager.com" crossorigin>';
    }
    ?>

    <!-- Preload fonts (optional, only .woff2 recommended) -->
    <link rel="preload" href="./assets/fonts/open-sans-v17-latin-regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/open-sans-v17-latin-600.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/open-sans-v17-latin-800.woff2" as="font" type="font/woff2" crossorigin>

    <!-- CSS -->
    <!-- Add more files, if needed, but try to consolidate it into one for better performance -->
    <link rel="stylesheet" type="text/css" href="./assets/css/style.min.css<?php echo '?v='.$version_nr; ?>">
    <!-- Use the TailwindCSS Play CDN, if you need to play around on a local setup - do not use this in production! -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

  </head>
  <body itemscope itemtype="http://schema.org/WebSite">
    
    <!-- Google Tag Manager (noscript) -->
    <?php
    if ($the_gtm_id != '') {
      echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . $the_gtm_id . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
    }
    ?>

    <link itemprop="url" href="<?php echo $the_page_url_full; ?>"/>
    <header class="bg-primary text-white text-2xl font-semibold p-6 md:p-8 lg:p-14 shadow-lg">
      <p>PHP Microsite Boilerplate V2</p>
    </header>

    <div class="bg-white shadow-lg">
      <div class="container mx-auto p-6 md:p-8 lg:p-20">
