<?php

/**
 * Purge and rebuild Directus cache.
 */

$provided_cache_code = '';

// Cache.
if ($page_slug == 'purge/directus_cache') {
  header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
  header('Cache-Control: post-check=0, pre-check=0', false);
  header("Pragma: no-cache");
  if (isset($url_query_vars['purge_rebuild_code'])) $provided_cache_code = $url_query_vars['purge_rebuild_code'];
  if ($_SERVER['REQUEST_METHOD'] === 'GET' and $random_cache_code == $provided_cache_code) {
    $cache_files = glob('./cache/*.json');
    foreach ($cache_files as $file) {
      if (is_file($file)) {
        unlink($file);
      }
    }
    header('Location: ' . $the_page_url . 'rebuild/directus_cache?purge_rebuild_code=' . $random_cache_code, true, 307);
    die('Directus local cache purged.<br>NEXT: Rebuilding core pages (please wait) ...');
  } else {
    http_response_code(400);
    $page_slug = 'error';
  }
}

// Rebuild.
if ($page_slug == 'rebuild/directus_cache' and $directus_url != '') {
  header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
  header('Cache-Control: post-check=0, pre-check=0', false);
  header('Pragma: no-cache');
  session_cache_limiter('private');
  session_cache_expire(1);
  if (isset($url_query_vars['purge_rebuild_code'])) $provided_cache_code = $url_query_vars['purge_rebuild_code'];
  if ($_SERVER['REQUEST_METHOD'] === 'GET' and $random_cache_code == $provided_cache_code) {
    session_start();
    // Step 1: Load all pages.
    if (!isset($_SESSION['rebuild_page_data_list']) and !isset($url_query_vars['rebuild_page']) and !isset($url_query_vars['rebuild_mix'])) {
      require_once './lib/directus_dyn_pages.php';
      $_SESSION['rebuild_page_data'] = json_encode($pages); // save it in a session variable
      $tmp_list = array();
      foreach ($language['available'] as $lang => $lang_name) { // build an array of pages to rebuild
        foreach ($pages[$lang] as $page_id => $page) {
          if (isset($pages[$lang][$page_id]['slug']) and isset($pages[$lang][$page_id]['directus_dyn'])) {
            if ($pages[$lang][$page_id]['directus_dyn']) $tmp_list[] = array($lang, $pages[$lang][$page_id]['slug']);
          }
        }
      }
      $_SESSION['rebuild_page_data_list'] = json_encode($tmp_list);
      header('Location: ' . $the_page_url . 'rebuild/directus_cache?rebuild_page=1&purge_rebuild_code=' . $random_cache_code, true, 307); // redirect to the next rebuild step
      die('Navigation defined.<br>NEXT: Iterating through single pages (please wait) ...');
    }
    // Step 2: Iterate through pages.
    if (isset($_SESSION['rebuild_page_data_list']) and isset($_SESSION['rebuild_page_data']) and isset($url_query_vars['rebuild_page'])) {
        $tmp_pages_var = json_decode($_SESSION['rebuild_page_data'], true);
        $tmp_list = json_decode($_SESSION['rebuild_page_data_list'], true);
        foreach ($tmp_list as $tmp_list_item) {
          $language['active'] = $tmp_list_item[0];
          $tmp_directus_data_var = new Page($tmp_list_item[1], $tmp_pages_var[$tmp_list_item[0]]);
        }        
        header('Location: ' . $the_page_url . 'rebuild/directus_cache?rebuild_mix=1&purge_rebuild_code=' . $random_cache_code, true, 307); // redirect to the next rebuild step
        die(count($tmp_pages_var) . ' pages rebuilt (please wait).');
    }
    // Step 3: Load additional resources (optional).
    if (isset($url_query_vars['rebuild_mix']) and $url_query_vars['rebuild_mix'] != '') {
      // Place any additional Directus calls you want to cache here (mind to set language manually). The following is an example.
      /*$language['active'] = 'en';
      $tmp_directus_data_var = getDirectusContent('general', '', '', false, '*.*', true);
      $language['active'] = 'de';
      $tmp_directus_data_var = getDirectusContent('general', '', '', false, '*.*', true);*/
    }
    // Step 4: Clean up.
    session_unset();
    session_destroy();
    die('Purging and rebuilding of the Directus local cache successfully accomplished.');
  } else {
    http_response_code(400);
    $page_slug = 'error';
  }
}


?>