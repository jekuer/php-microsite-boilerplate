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

    // First: Purge.
    $limiter = array(); // use the query param "limit" to provide a comma separated list of strings, if you only want to purge specific files. If provided, only files, which contain (so, you do not need to mind the whole file name) one of the strings in their filename get purged.
    if (isset($url_query_vars['limit'])) {
      $url_query_vars['limit'] = make_safe($url_query_vars['limit']);
      $limiter = explode(',', $url_query_vars['limit']);
    }
    $cache_files = glob('./cache/*.json');
    foreach ($cache_files as $file) {
      if (is_file($file)) {
        if (!empty($limiter)) {
          foreach($limiter as $pattern) {
            if (stripos($file,$pattern) !== false) unlink($file);
          }
        } else {
          unlink($file);
        }
      }
    }

    // Next: Rebuild.
    // Step 1: Load all pages.
    $services_page_id = '';
    require_once './lib/directus_dyn_pages.php';
    $rebuild_page_data_list = array();
    foreach ($language['available'] as $lang => $lang_name) { // build an array of pages to rebuild
      foreach ($pages[$lang] as $page_id => $page) {
        if (isset($pages[$lang][$page_id]['slug']) and isset($pages[$lang][$page_id]['directus_dyn'])) {
          if ($pages[$lang][$page_id]['directus_dyn']) $rebuild_page_data_list[] = array($lang, $pages[$lang][$page_id]['slug']);
        }
      }
    }
    // Step 2: Iterate through pages.
    foreach ($rebuild_page_data_list as $tmp_list_item) {
      $language['active'] = $tmp_list_item[0];
      $tmp_directus_data_var = new Page($tmp_list_item[1], $pages[$tmp_list_item[0]]);
    }        
    // Step 3: Load additional resources (optional).
    // Place any additional Directus calls you want to cache here (mind to set language manually). The following is an example.
    /*$language['active'] = 'en';
    $tmp_directus_data_var = getDirectusContent('general', '', '', false, '*.*', true);
    $language['active'] = 'de';
    $tmp_directus_data_var = getDirectusContent('general', '', '', false, '*.*', true);*/

    die('Purging and rebuilding of the Directus CMS local cache successfully accomplished. Please close this tab now.');
    
  } else {
    http_response_code(400);
    $page_slug = 'error';
  }
}

?>