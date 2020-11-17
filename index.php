<?php

/**
 * +++++++++++++++++++++++++
 * PHP Microsite Boilerplate
 * +++++++++++++++++++++++++
 * 
 * Version: 1.3.0
 * Creator: Jens Kuerschner (https://jenskuerschner.de)
 * Project: https://github.com/jekuer/php-microsite-boilerplate
 * License: GNU General Public License v3.0	(gpl-3.0)
 */


// Load default configuration.
$language = array();
require_once './config.php';
// error_reporting(E_ALL | E_STRICT); // enable for better debugging.


// Set Security Headers.
// Only enable this, if it is not possible on the server side (e.g. via htaccess on Apache).
// For testing and more details, see https://securityheaders.com/ .
// require_once './templates/php_security_headers.php';


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


// Gettext setup. Based on a slightly optimized php-gettext 1.0.12 (https://launchpad.net/php-gettext) to enable gettext even on systems, where it is not installed.
if (isset($language['locale']) and is_array($language['locale']) and !empty($language['locale'])) {
  $locale = $language['locale'][$language['active']];
  define('LOCALE_DIR', realpath('./') .'/translations');
  $gettext_domain = 'main';
  $text_encoding = 'UTF-8';
  mb_internal_encoding($text_encoding);
  header("Content-type: text/html; charset=$text_encoding");

  // The following block should be used for the php-gettext fallback implementation, which looks for native support first and then falls back to the emulation. Mind that this uses "T_" as gettext alias! If you do not need the emulation, you can use "_" as alias.
  require_once './lib/gettext/gettext.inc';
  T_setlocale(LC_MESSAGES, $locale);
  T_bindtextdomain($gettext_domain, LOCALE_DIR);
  T_bind_textdomain_codeset($gettext_domain, $text_encoding);
  T_textdomain($gettext_domain);  
  // An alternative with regular gettext alias could look as follows:
  /*T_setlocale(LC_MESSAGES, $locale);
  bindtextdomain($gettext_domain, LOCALE_DIR);
  bind_textdomain_codeset($gettext_domain, $text_encoding);
  textdomain($gettext_domain);*/
  setlocale(LC_TIME, $locale . '.utf8');
  setlocale(LC_MONETARY, $locale);
  setlocale(LC_NUMERIC, $locale . '.utf8');
}


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