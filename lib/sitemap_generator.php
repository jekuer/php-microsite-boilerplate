<?php

/**
 * Sitemap generator.
 */
function generate_sitemap() {
  global $language, $pages, $the_page_url;
  $sitemap_code = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
  $sitemap_code .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;
  foreach ($pages as $lang => $page) {
    // adjust language part for url
    if ($lang == $language['default']) {
      $lang = '';
    } else {
      $lang = $lang . '/';
    }
    foreach ($page as $page_id => $pagedetails) {
      // skip if sitemaps has been disabled for this page
      if (isset($page[$page_id]['sitemap']) and !$page[$page_id]['sitemap']) continue;
      // skip if the page redirects
      if (isset($page[$page_id]['redirect']) and $page[$page_id]['redirect'] != '') continue;
      // get slug
      if (isset($page[$page_id]['slug']) and $page[$page_id]['slug'] != '') {
        $slug = $page[$page_id]['slug'];
      } else {
        $slug = $page_id;
      } 
      // adjust slug and priority
      if ($slug == 'main') {
        $slug = '';
        $priority = '1.0';
      } else {
        $slug = $slug . '/';
        $priority = '0.8';
      }
      $date_updated = '';
      if (isset($page[$page_id]['date_updated']) and $page[$page_id]['date_updated'] != '') $date_updated = '<lastmod>' . $page[$page_id]['date_updated'] . '</lastmod>' . PHP_EOL;  
      $priority = '<priority>' . $priority . '</priority>' . PHP_EOL;    
      // create <url> part
      $sitemap_code .= '<url>' . PHP_EOL . '<loc>' . $the_page_url . $lang . $slug . '</loc>' . PHP_EOL;
      $sitemap_code .= $date_updated;
      $sitemap_code .= $priority; // optional! Google does not recognize this, but other search engines might. Decide on your own, if you want to keep it :).
      $sitemap_code .= '</url>' . PHP_EOL;
    }
  }
  $sitemap_code .= '</urlset>';
  return $sitemap_code;
}


?>
