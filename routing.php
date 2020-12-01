<?php

/**
 * Defining the different pages and their settings.
 */

// All pages.
$pages = array();
$directus_pages = array();
// Mind to put pages per language, even if you only have one language. Use the language code as it is used as key at config.php
// Use the same id per language for the same page.
foreach ($language['available'] as $lang => $lang_name) {
  $pages[$lang] = array();
}

/* There are two ways to define pages:
1) With all details defined here as described below (option to directly connect to a specific item within Directus CMS).
2) Defining one or more Directus CMS collections, which generate respective pages automatically. See the bottom of this page for further details.
-> You can also combine those two approaches, defining some pages here and still have a more dynamic approach for other pages via Directus (e.g. statics pages vs. blog entries).
*/


/* Regular Pages */

// Fields:
// - id                   (overall unique identifier, no real field) (the default slug for this page; needs to be the same per language; to reference the home page, use 'main'; mind to NOT use 'amp, 'default', or any of your language short names (e.g. 'de')) (string)
// - slug                 (optional slug, if you do not want to use the id as slug (e.g. if you want to have different slugs per translation)) (string)
// - alias                (if the entry/id acts as an alias for another id, put the target id here; this won't redirect, but load the target page's content under this slug) (string)
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
// - directus_id          (itemId within this collection, e.g. "4") (if set, the site will connect to directus and retrieve the information from this item in the respective collection. You can then use it via $the_page->directus['FIELD']) (string)

// Id, View, and Name are required. At all other fields, if kept empty or not defined, the default setting is used.

/* // Example
$id = 'legal-notice';
$pages['en'][$id]['slug'] = 'legal-company-information';
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

$id = 'offline'; // required for PWA
$pages['en'][$id]['view'] = 'offline';
$pages['en'][$id]['name'] = 'Offline';
$pages['en'][$id]['title'] = 'Offline | ' . $the_page_meta_defaults['title'];
$pages['en'][$id]['description'] = 'You are offline. Please check your internet conncetion and try again.';
$pages['en'][$id]['sitemap'] = false;
$pages['en'][$id]['robots'] = 'noindex,nofollow';

$id = 'error'; // required for 404
$pages['en'][$id]['view'] = 'error';
$pages['en'][$id]['name'] = 'Error';
$pages['en'][$id]['title'] = 'Error | ' . $the_page_meta_defaults['title'];
$pages['en'][$id]['description'] = 'It seems that the requested page is not or no longer available.';
$pages['en'][$id]['sitemap'] = false;
$pages['en'][$id]['robots'] = 'noindex,nofollow';
$pages['en'][$id]['amp'] = true;

$id = 'main'; // describes the home page; kill this and following respective non-required pages, if you plan to include them dynamically via Directus CMS.
$pages['en'][$id]['view'] = 'main_en';
$pages['en'][$id]['name'] = 'Home';
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

$id = 'offline'; // required for PWA
$pages['de'][$id]['view'] = 'offline';
$pages['de'][$id]['name'] = 'Offline';
$pages['de'][$id]['title'] = 'Offline | ' . $the_page_meta_defaults['title'];
$pages['de'][$id]['description'] = 'Du bist leider offline. Prüfe deine Internetverbindung und versuche es danach erneut.';
$pages['de'][$id]['sitemap'] = false;
$pages['de'][$id]['robots'] = 'noindex,nofollow';

$id = 'error'; // required for 404
$pages['de'][$id]['view'] = 'error';
$pages['de'][$id]['name'] = 'Error';
$pages['de'][$id]['title'] = 'Error | ' . $the_page_meta_defaults['title'];
$pages['de'][$id]['description'] = 'Die gewünschte Seite gibt es wohl nicht (mehr).';
$pages['de'][$id]['sitemap'] = false;
$pages['de'][$id]['robots'] = 'noindex,nofollow';
$pages['de'][$id]['amp'] = true;

$id = 'main';
$pages['de'][$id]['view'] = 'main_de';
$pages['de'][$id]['name'] = 'Startseite';
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

$id = 'offline'; // required for PWA
$pages['es'][$id]['view'] = 'offline';
$pages['es'][$id]['name'] = 'Offline';
$pages['es'][$id]['title'] = 'Offline | ' . $the_page_meta_defaults['title'];
$pages['es'][$id]['description'] = 'Me temo que estás desconectado. Comprueba tu conexión a Internet e inténtalo de nuevo después.';
$pages['es'][$id]['sitemap'] = false;
$pages['es'][$id]['robots'] = 'noindex,nofollow';

$id = 'error'; // required for 404
$pages['es'][$id]['view'] = 'error';
$pages['es'][$id]['name'] = 'Error';
$pages['es'][$id]['title'] = 'Error | ' . $the_page_meta_defaults['title'];
$pages['es'][$id]['description'] = 'La página que solicitó ya no existe.';
$pages['es'][$id]['sitemap'] = false;
$pages['es'][$id]['robots'] = 'noindex,nofollow';
$pages['es'][$id]['amp'] = true;

$id = 'main';
$pages['es'][$id]['view'] = 'main_es';
$pages['es'][$id]['name'] = 'Home';
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




/* Directus CMS dynamic pages */

// Automatically pulls all fields into one array (except those sub-collections, which do not belong to the respective language). You can then use them via $the_page->directus['FIELD'])
// Mind that this will automatically create a page for each language, expecting each page to be translated within Directus!
// Also mind that the language codes in the config here are required to match the language codes from your Directus system!

$directus_pages['collections'] = array(); // The collections, which hold the single pages (not the translated elements) (array). If empty, this feature will be skipped.
$directus_pages['slug'] = array(); // The field, which holds the slug. If different per collection, write as array. For nested translations, add a period before the name, e.g. ".slug". Mind to define it for each collection! Example: array('', '', 'slug', '');
$directus_pages['slug_depth'] = array(); // If you want to define a deeper URL structure for one collection, you can add the second level here. E.g. "blog" would lead to a page appear at DOMAIN.COM/blog/slug. Mind to define it for each collection! Example: array('', '', 'blog', '');
$directus_pages['respect_status'] = true; // If set true, only pages with a field "status" and the value "published" will be loaded. Mind that all collections need a fiels "status" if set to true!
$directus_pages['view'] = ''; // The field, which holds the name of the view file. If different per collection, write as array. For nested translations, add a period before the name, e.g. ".view". (if empty, will look for a file, which matches the slug).
$directus_pages['controller'] = ''; // The field, which holds the name of the controller file. If different per collection, write as array. For nested translations, add a period before the name, e.g. ".view". (optional; if empty, gets skipped).
$directus_pages['name'] = ''; // The field, which holds the title as it appears in menus. If different per collection, write as array. For nested translations, add a period before the name, e.g. ".name". (required!).
$directus_pages['title'] = ''; // The field, which holds the meta title. If different per collection, write as array. For nested translations, add a period before the name, e.g. ".title". (If empty, defaults to the default).
$directus_pages['description'] = ''; // The field, which holds the meta description. If different per collection, write as array. For nested translations, add a period before the name, e.g. ".description". (If empty, defaults to the default).
$directus_pages['keywords'] = ''; // The field, which holds the meta keywords. If different per collection, write as array. For nested translations, add a period before the name, e.g. ".keywords". (If empty, defaults to the default).
$directus_pages['robots'] = ''; // The field, which holds the robots information (if empty, defaults to the default). If different per collection, write as array.
$directus_pages['amp'] = ''; // The field, which defines, whether the page has an AMP version or not (if empty, defaults to false). If different per collection, write as array.
$directus_pages['redirect'] = ''; // The field, which defines, whether the page redirects to another URL (if empty, defaults to ''). If different per collection, write as array.
$directus_pages['sitemap'] = ''; // The field, which holds information, if the page should be included into the sitemap or not (if empty, defaults to true). If different per collection, write as array.
$directus_pages['translation_block'] = 'translations'; // The block (name of the sub level), which holds translated elements (usually "translations", if you did not change it).
$directus_pages['language_field'] = 'languages_code'; // The name of the field, which defines the language of a specific block (usually "language" in V8 and "languages_code" in V9).


?>
