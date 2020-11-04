<?php

/**
 * Defining the different pages and their settings.
 */

// All pages.
$pages = array();
// Mind to put pages per language, even if you only have one language. Use the language code as it is used as key at config.php
// Use the same id per language for the same page.
foreach ($language['available'] as $lang => $lang_name) {
  $pages[$lang] = array();
}


// Fields:
// - alias                (if the entry/id acts as an alias for another id, put the target id here) (string)
// - view                 (the file to load from folder 'pages') (string)
// - controller           (the file to load from folder 'controller'; gets included before any HTML) (string)
// - name                 (display name for menus) (string)
// - title                (SEO) (string)
// - description          (SEO) (string)
// - keywords             (SEO) (string)
// - robots               (e.g. 'noindex,nofollow') (string)
// - amp                  (if the page works as AMP; default = false) (mind that the pages content needs to be AMP compliant! Go to https://validator.ampproject.org/ for validation.) (boolean)
// - redirect             (if set, redirects) (url)
// - sitemap              (if the page is included into the sitemap; default = true) (boolean)
// - directus_collection  (collectionName, e.g. "mypages") (string)
// - directus_id          (itemId within this collection, e.g. "4") (if set, the site will connect to directus and retrieve the meta information from this item in the respective collection. You can then use it via $the_page->directus['META_FIELD']) (string)

// File and Name are required. At all other fields, if kept empty or not defined, the default setting is used.
// The id variable needs to hold the path slug. To reference the home page, use 'main'.
// Mind to NOT use 'amp, 'default', or any of your language short names (e.g. 'de') as id!

/* // Example
$id = 'legal-notice';
$pages['en'][$id]['alias'] = '';
$pages['en'][$id]['view'] = 'legal-notice';
$pages['en'][$id]['controller'] = '';
$pages['en'][$id]['name'] = 'Legal Notice';
$pages['en'][$id]['title'] = 'Legal Notice | ' . $the_page_meta_defaults['title'];
$pages['en'][$id]['description'] = 'Legal information about this website.';
$pages['en'][$id]['keywords'] = '';
$pages['en'][$id]['robots'] = 'noindex,nofollow';
$pages['en'][$id]['amp'] = true;
$pages['en'][$id]['redirect'] = '';
$pages['en'][$id]['sitemap'] = false;
$pages['en'][$id]['directus_collection'] = '';
$pages['en'][$id]['directus_id'] = '';
*/


// ENGLISH

$id = 'main'; // describes the home page
$pages['en'][$id]['view'] = 'main_en';
$pages['en'][$id]['name'] = 'Home';
$pages['en'][$id]['amp'] = true;

$id = 'offline'; // required for PWA
$pages['en'][$id]['view'] = 'offline_en';
$pages['en'][$id]['name'] = 'Offline';
$pages['en'][$id]['title'] = 'Offline | ' . $the_page_meta_defaults['title'];
$pages['en'][$id]['description'] = 'You are offline. Please check your internet conncetion and try again.';
$pages['en'][$id]['sitemap'] = false;
$pages['en'][$id]['robots'] = 'noindex,nofollow';

$id = 'error'; // required for 404
$pages['en'][$id]['view'] = 'error_en';
$pages['en'][$id]['name'] = 'Error';
$pages['en'][$id]['title'] = 'Error | ' . $the_page_meta_defaults['title'];
$pages['en'][$id]['description'] = 'It seems that the requested page is not or no longer available.';
$pages['en'][$id]['sitemap'] = false;
$pages['en'][$id]['robots'] = 'noindex,nofollow';
$pages['en'][$id]['amp'] = true;

$id = 'legal-notice';
$pages['en'][$id]['view'] = 'legal-notice_en';
$pages['en'][$id]['name'] = 'Legal Notice';
$pages['en'][$id]['title'] = 'Legal Notice | ' . $the_page_meta_defaults['title'];
$pages['en'][$id]['description'] = 'Legal information about this website.';
$pages['en'][$id]['robots'] = 'noindex,nofollow';
$pages['en'][$id]['amp'] = true;

$id = 'privacy-policy';
$pages['en'][$id]['view'] = 'privacy-policy_en';
$pages['en'][$id]['name'] = 'Privacy Policy';
$pages['en'][$id]['title'] = 'Privacy Policy | ' . $the_page_meta_defaults['title'];
$pages['en'][$id]['description'] = 'Privacy policy information about this website.';
$pages['en'][$id]['robots'] = 'noindex,nofollow';
$pages['en'][$id]['amp'] = true;

/*$id = 'directus';
$pages['en'][$id]['view'] = 'sample_directus';
$pages['en'][$id]['name'] = 'Directus Sample';
$pages['en'][$id]['controller'] = 'sample_directus';
$pages['en'][$id]['robots'] = 'noindex,nofollow';
$pages['en'][$id]['directus_collection'] = 'micrositepages';
$pages['en'][$id]['directus_id'] = '1';*/

// GERMAN

$id = 'main';
$pages['de'][$id]['view'] = 'main_de';
$pages['de'][$id]['name'] = 'Startseite';
$pages['de'][$id]['amp'] = true;

$id = 'offline'; // usually not used, since there can be only one offline fallback
$pages['de'][$id]['view'] = 'offline_de';
$pages['de'][$id]['name'] = 'Offline';
$pages['de'][$id]['title'] = 'Offline | ' . $the_page_meta_defaults['title'];
$pages['de'][$id]['description'] = 'Du bist leider offline. Prüfe deine Internetverbindung und versuche es danach erneut.';
$pages['de'][$id]['sitemap'] = false;
$pages['de'][$id]['robots'] = 'noindex,nofollow';

$id = 'error';
$pages['de'][$id]['view'] = 'error_de';
$pages['de'][$id]['name'] = 'Error';
$pages['de'][$id]['title'] = 'Error | ' . $the_page_meta_defaults['title'];
$pages['de'][$id]['description'] = 'Die gewünschte Seite gibt es wohl nicht (mehr).';
$pages['de'][$id]['sitemap'] = false;
$pages['de'][$id]['robots'] = 'noindex,nofollow';
$pages['de'][$id]['amp'] = true;

$id = 'legal-notice';
$pages['de'][$id]['view'] = 'legal-notice_de';
$pages['de'][$id]['name'] = 'Impressum';
$pages['de'][$id]['title'] = 'Impressum | ' . $the_page_meta_defaults['title'];
$pages['de'][$id]['description'] = 'Rechtliche Informationen zu dieser Webseite.';
$pages['de'][$id]['robots'] = 'noindex,nofollow';
$pages['de'][$id]['amp'] = true;

$id = 'privacy-policy';
$pages['de'][$id]['view'] = 'privacy-policy_de';
$pages['de'][$id]['name'] = 'Datenschutz';
$pages['de'][$id]['title'] = 'Datenschutz | ' . $the_page_meta_defaults['title'];
$pages['de'][$id]['description'] = 'Datenschutzbestimmungen und -Informationen zu dieser Webseite.';
$pages['de'][$id]['robots'] = 'noindex,nofollow';
$pages['de'][$id]['amp'] = true;

// SPANISH

$id = 'main';
$pages['es'][$id]['view'] = 'main_es';
$pages['es'][$id]['name'] = 'Home';
$pages['es'][$id]['amp'] = true;

$id = 'offline'; // usually not used, since there can be only one offline fallback
$pages['es'][$id]['view'] = 'offline_es';
$pages['es'][$id]['name'] = 'Offline';
$pages['es'][$id]['title'] = 'Offline | ' . $the_page_meta_defaults['title'];
$pages['es'][$id]['description'] = 'Me temo que estás desconectado. Comprueba tu conexión a Internet e inténtalo de nuevo después.';
$pages['es'][$id]['sitemap'] = false;
$pages['es'][$id]['robots'] = 'noindex,nofollow';

$id = 'error';
$pages['es'][$id]['view'] = 'error_es';
$pages['es'][$id]['name'] = 'Error';
$pages['es'][$id]['title'] = 'Error | ' . $the_page_meta_defaults['title'];
$pages['es'][$id]['description'] = 'La página que solicitó ya no existe.';
$pages['es'][$id]['sitemap'] = false;
$pages['es'][$id]['robots'] = 'noindex,nofollow';
$pages['es'][$id]['amp'] = true;

$id = 'legal-notice';
$pages['es'][$id]['view'] = 'legal-notice_es';
$pages['es'][$id]['name'] = 'Avisio Legal';
$pages['es'][$id]['title'] = 'Avisio Legal | ' . $the_page_meta_defaults['title'];
$pages['es'][$id]['description'] = 'Información legal sobre este sitio web.';
$pages['es'][$id]['robots'] = 'noindex,nofollow';
$pages['es'][$id]['amp'] = true;

$id = 'privacy-policy';
$pages['es'][$id]['view'] = 'privacy-policy_es';
$pages['es'][$id]['name'] = 'Protección de datos';
$pages['es'][$id]['title'] = 'Protección de datos | ' . $the_page_meta_defaults['title'];
$pages['es'][$id]['description'] = 'Política de privacidad e información sobre este sitio web.';
$pages['es'][$id]['robots'] = 'noindex,nofollow';
$pages['es'][$id]['amp'] = true;

// REDIRECTS

$id = 'to-the-repo';
$pages['en'][$id]['redirect'] = 'https://github.com/jekuer/php-microsite-boilerplate';


?>
