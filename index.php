<?php

/**
 * +++++++++++++++++++++++++
 * PHP Microsite Boilerplate
 * +++++++++++++++++++++++++
 * 
 * Version: 1.2.0
 * Creator: Jens Kuerschner (https://jenskuerschner.de)
 * Project: https://github.com/jekuer/php-microsite-boilerplate
 * License: GNU General Public License v3.0	(gpl-3.0)
 */


// Load default configuration.
$language = array();
require_once './config.php';


// Load general additional functions and classes.
// Include more, if needed.
require_once './lib/helper_functions.php';
if ($directus_url != '') require_once './lib/directus_connect.php';
require_once './class/class.page.php';


// URL parsing.
$amp = false;
$the_page_url = filter_var($the_page_url, FILTER_SANITIZE_URL); // the base URL, cleaned up.
$the_page_url = rtrim($the_page_url, '/') . '/';
$the_page_url_full = $the_page_url; // holds the base url plus settings path elements (amp, language).
if (isset($_SERVER['REQUEST_URI'])) {
  $current_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL); // holds the full url incl. slug.
  $current_url = rtrim($current_url, '/') . '/';
} else {
  $current_url = $the_page_url_full;
}
require_once './lib/url_parsing.php';


// Set Security Headers.
// Only enable this, if it is not possible on the server side (e.g. via htaccess on Apache).
// For testing and more details, see https://securityheaders.com/ .
// require_once './templates/php_security_headers.php';


// Check for redirects
require_once './redirects.php';
if (isset($redirects[$language['active']][$url_parts[0]]['target']) and $redirects[$language['active']][$url_parts[0]]['target'] != '') {
  header('Location: ' . $redirects[$language['active']][$url_parts[0]]['target'], true, 301);
  die();
}


// Routing.
require_once './routing.php';
if (!isset($url_parts[0]) or $url_parts[0] == '') $url_parts[0] = 'main';
$page_id = $url_parts[0];
if (isset($url_parts[1]) and $url_parts[1] != '') $page_id = $page_id . '/' . $url_parts[1]; // enables an optional second URL level.
if ($directus_url != '' and isset($directus_pages['collections']) and !empty($directus_pages['collections'])) { // load Directus pages, if set.
  require_once './lib/directus_dyn_pages.php';
}


// Check for deployment hook call.
if ($page_id == $the_deployment_slug) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once $the_deployment_script;
    die();
  } else {
    http_response_code(400);
    $page_id = 'error';
  }
}


// Check for cache purge call.
if ($page_id == 'purge/directus_cache') {
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cache_files = glob('./cache/*.json');
    foreach ($cache_files as $file) {
      if (is_file($file)) {
        unlink($file);
      }
    }
    die('Directus local cache purged.');
  } else {
    http_response_code(400);
    $page_id = 'error';
  }
}


// Check for sitemap call.
if ($page_id == 'sitemap.xml') {
  require_once './lib/sitemap_generator.php';
  header('Content-Type: application/xml');
  echo generate_sitemap();
  die();
}


// In all other cases, prepare page.
$the_page = new Page($page_id, $pages[$language['active']], $the_page_meta_defaults);
if ($the_page->amp == false) $amp = false;


// Render page (compressed and with stripped HTML comments).
ob_start("ob_html_compress");
if ($amp) {
  if ($the_page->controller != '') include_once './controller/'. $the_page->controller .'.php';
  include_once './templates/header_amp.php';
  include_once './pages/'. $the_page->view .'.php';
  include_once './templates/footer_amp.php';
} else {
  if ($the_page->controller != '') include_once './controller/'. $the_page->controller .'.php';
  include_once './templates/header.php';
  include_once './pages/'. $the_page->view .'.php';
  include_once './templates/footer.php';
}
ob_end_flush();


?>