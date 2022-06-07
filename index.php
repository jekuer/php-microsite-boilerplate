<?php

/**
 * +++++++++++++++++++++++++
 * PHP Microsite Boilerplate
 * +++++++++++++++++++++++++
 * 
 * Version: 2.0.11
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
$the_page_url = filter_var($the_page_url, FILTER_SANITIZE_URL); // the base URL, cleaned up.
$the_page_url = rtrim($the_page_url, '/') . '/';
$the_page_url_full = $the_page_url; // holds the base url plus settings path elements (e.g. language).
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


// Routing.
require_once './routing.php';
if (!isset($url_parts[0]) or $url_parts[0] == '') $url_parts[0] = 'main';
$page_slug = $url_parts[0];
if (isset($url_parts[1]) and $url_parts[1] != '') $page_slug = $page_slug . '/' . $url_parts[1]; // enables an optional second URL level.


// Check for cache purge/rebuild call (via YOURDOMAIN.com/purge/directus_cache?purge_rebuild_code=XXXXX - set the purge_rebuild_code in the config.php).
require_once './lib/cache_purge_rebuild.php';


// Load Directus pages, if set.
if ($directus_url != '' and isset($directus_pages['collections']) and !empty($directus_pages['collections'])) {
  require_once './lib/directus_dyn_pages.php';
}


// Check for deployment hook call.
if ($page_slug == $the_deployment_slug) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once $the_deployment_script;
    exit();
  } else {
    http_response_code(400);
    $page_slug = 'error';
  }
}


// Check for sitemap call.
if ($page_slug == 'sitemap.xml') {
  require_once './lib/sitemap_generator.php';
  header('Content-Type: application/xml');
  echo generate_sitemap();
  exit();
}


// In all other cases, prepare page.
$the_page = new Page($page_slug, $pages[$language['active']], $the_page_meta_defaults);


// Check for initial language via cookie or browser language and redirect automatically.
// Optional. Mind that this could break, if you rely on heavy page chaching and/or proxy services. In this case, remove this and implement an alternative via JavaScript to handle this on the client side (the default way).
/*if (isset($_COOKIE['language_select'])) {
  $cookie_lang = make_safe($_COOKIE['language_select']);
  if ($cookie_lang != $language['active']) {
    if ($same_site_referrer == false) {
      // Redirect if possible.
      if (isset($pages[$cookie_lang][$the_page->id])) {
        $lang_redirect_url = $the_page_url;
        if ($language['default'] != $cookie_lang) $lang_redirect_url .= $cookie_lang . '/';
        if (isset($pages[$cookie_lang][$the_page->id]['slug']) and $pages[$cookie_lang][$the_page->id]['slug'] != '') {
          $tmp_slug = $pages[$cookie_lang][$the_page->id]['slug'];
        } else {
          $tmp_slug = $the_page->id;
        }
        if ($tmp_slug != 'main') {
          $lang_redirect_url .= $tmp_slug . '/';
        }
        header('Location: ' . $lang_redirect_url, true, 307);
        exit();
      }
    } else {
      // Update cookie.
      $tmp_domain = parse_url($the_page_url, PHP_URL_HOST);
      setcookie('language_select', $language['active'], time() + (86400 * 30), "/", $tmp_domain); // 86400 = 1 day.
    }
  }
} else {
  // Set cookie.
  $tmp_domain = parse_url($the_page_url, PHP_URL_HOST);
  setcookie('language_select', $language['active'], time() + (86400 * 30), "/", $tmp_domain); // 86400 = 1 day.
  // Compare to browser language.
  $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
  if ($same_site_referrer = false and $browser_lang != $language['active']) {
    if (isset($pages[$browser_lang][$the_page->id])) {
      // This indicates that the user is new to the page and his browser language could be supported by one of the translations.
      // You could now offer him a redirect or highlight the language switcher.
      // Auto-Redirect is not recommended here in order to not piss off any search engine crawlers!
    }
  }
}*/


// Check for redirects, if no page found.
if ($the_page->id == 'error') {
  require_once './redirects.php';
  if (isset($redirects[$full_url_parts]['target']) and $redirects[$full_url_parts]['target'] != '') {
    if (!isset($redirects[$full_url_parts]['type']) or $redirects[$full_url_parts]['type'] == '') $redirects[$full_url_parts]['type'] = 301;
    header('Location: ' . $redirects[$full_url_parts]['target'], true, $redirects[$full_url_parts]['type']);
    exit();
  }
}


// Render page (compressed and with stripped HTML comments).
ob_start("ob_html_compress");
if ($the_page->controller != '' and file_exists('./controller/'. $the_page->controller .'.php')) include_once './controller/'. $the_page->controller .'.php';
include_once './templates/header.php';
include_once './pages/'. $the_page->view .'.php';
include_once './templates/footer.php';
ob_end_flush();


?>