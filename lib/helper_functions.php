<?php

/**
 * Language Switcher.
 */

function create_language_switcher($page_id, $amp_version = false) {
  global $language, $pages;
  $language_switcher = '';
  $translated_pages_count = 0;
  $lang_menu = '';
  $goto_lang = '';
  $slug = '';
  $tabindexcount = 81;
  if ($page_id != 'main') $slug = $page_id . '/';
  foreach ($language['available'] as $lang => $lang_name) { // Count translated pages and prepare list.
    if (!isset($pages[$lang][$page_id]['view'])) continue;
    $translated_pages_count++;
    if ($lang != $language['active']) $goto_lang = $lang;
    if ($lang == $language['active']) {
      $lang_menu .= '<span class="lang_menu_item_active">' . $lang_name . '</span>';
    } else {
      if ($language['default'] != $lang) $slug = $lang . '/' . $slug;
      $tabindexcount++;
      $lang_menu .= '<span class="lang_menu_item"><a tabindex="' . $tabindexcount . '" href="';
      if ($amp_version) $lang_menu .= '/amp';
      $lang_menu .= '/' . $slug . '">' . $lang_name . '</a></span>';
      $slug = '';
      if ($page_id != 'main') $slug = $page_id . '/';
    }
  }
  if (count($language['available']) == 2 and $translated_pages_count == 2 ) { // If there are exactly 2 language generally and specifically for this page available, offer a direct change option.
    if ($language['default'] != $goto_lang) $slug = $goto_lang . '/' . $slug;
    $language_switcher = '<a href="/' . $slug . '" class="language_switcher">&#127760;&nbsp;' . $language['available'][$goto_lang] . '&nbsp;&#9656;</a>';
  }
  if (count($language['available']) > 2 and $translated_pages_count > 1) { // If there are more than 2 language generally available and at least one additional version of the current page, offer a more complex menu.
    if ($amp_version) {
      $language_switcher = '<span class="language_switcher" on="tap:lang_menu.show" role="button" tabindex="80">&#127760;&nbsp;' . $language['available'][$language['active']] . '&nbsp;&#9662;</span><span id="lang_menu" hidden><span id="lang_menu_overlay" on="tap:lang_menu.hide" role="img" tabindex="200"></span><span id="lang_menu_banner"><span id="lang_menu_close" on="tap:lang_menu.hide" role="button" tabindex="81">X</span>' . $lang_menu . '</span></span>';
    } else {
      $language_switcher = '<span class="language_switcher" onClick="document.getElementById(\'lang_menu\').style.display=\'block\';">&#127760;&nbsp;' . $language['available'][$language['active']] . '&nbsp;&#9662;</span><span id="lang_menu"><span id="lang_menu_overlay" onClick="document.getElementById(\'lang_menu\').style.display=\'none\';"></span><span id="lang_menu_banner"><span id="lang_menu_close" onClick="document.getElementById(\'lang_menu\').style.display=\'none\';">X</span>' . $lang_menu . '</span></span>';
    }
  }
  return $language_switcher;
}


/**
 * Some more handy functions.
 */

function make_safe($v) { // strip html code, remove spaces, remove any strange special characters and more
  if (is_array($v)) {
    foreach ($v as $key => $subv) {
      $v[$key] = cleanString($subv);
      if (get_magic_quotes_gpc()) $v[$key] = stripslashes($v[$key]);
      $v[$key] = preg_replace('/[^A-Za-züöäßÜÖÄ0-9@&+;_\. -]/', '', $v[$key]);
      $v[$key] = htmlentities($v[$key], ENT_QUOTES);
      $v[$key] = strip_tags($v[$key]);
      $v[$key] = str_replace(" ", "", $v[$key]);
    }
  } else {
    $v = cleanString($v);
    if (get_magic_quotes_gpc()) $v = stripslashes($v);
    $v = preg_replace('/[^A-Za-züöäßÜÖÄ0-9@&+;_\. -]/', '', $v);
    $v = htmlentities($v, ENT_QUOTES);
    $v = strip_tags($v);
    $v = str_replace(" ", "", $v);
  }
  return $v;
}


function make_safe2($v) { // keeps spaces (except beginning and end)
  if (is_array($v)) {
    foreach ($v as $key => $subv) {
      $v[$key] = cleanString($subv);
      if (get_magic_quotes_gpc()) $v[$key] = stripslashes($v[$key]);
      $v[$key] = preg_replace('/[^A-Za-züöäßÜÖÄ0-9@&+;_\. -]/', '', $v[$key]);
      $v[$key] = htmlentities($v[$key], ENT_QUOTES);
      $v[$key] = strip_tags($v[$key]);
      $v[$key] = trim($v[$key]);
    }
  } else {
    $v = cleanString($v);
    if (get_magic_quotes_gpc()) $v = stripslashes($v);
    $v = preg_replace('/[^A-Za-züöäßÜÖÄ0-9@&+;_\. -]/', '', $v);
    $v = htmlentities($v, ENT_QUOTES);
    $v = strip_tags($v);
    $v = trim($v);
  }
  return $v;
}


function make_safe3($v) { // keeps spaces (except beginning and end), but converts slashes
  if (is_array($v)) {
    foreach ($v as $key => $subv) {
      $v[$key] = cleanString($subv);
      $v[$key] = htmlentities($v[$key], ENT_QUOTES);
      if (get_magic_quotes_gpc()) $v[$key] = stripslashes($v[$key]);
      $v[$key] = strip_tags($v[$key]);
      $v[$key] = trim($v[$key]);
      $v[$key] = str_replace("/", "&#47;", $v[$key]);
      $v[$key] = str_replace("\\", "&#92;", $v[$key]);
    }
  } else {
    $v = cleanString($v);
    $v = htmlentities($v, ENT_QUOTES);
    if (get_magic_quotes_gpc()) $v = stripslashes($v);
    $v = strip_tags($v);
    $v = trim($v);
    $v = str_replace("/", "&#47;", $v);
    $v = str_replace("\\", "&#92;", $v);
  }
  return $v;
}


function cleanString($text) {
  $utf8 = array(
    '/[áàâãª]/u'  =>  'a',
    '/[ÁÀÂÃ]/u'   =>  'A',
    '/[ÍÌÎÏ]/u'   =>  'I',
    '/[íìîï]/u'   =>  'i',
    '/[éèêë]/u'   =>  'e',
    '/[ÉÈÊË]/u'   =>  'E',
    '/[óòôõº]/u'  =>  'o',
    '/[ÓÒÔÕ]/u'   =>  'O',
    '/[úùû]/u'    =>  'u',
    '/[ÚÙÛ]/u'    =>  'U',
    '/ç/'         =>  'c',
    '/Ç/'         =>  'C',
    '/ñ/'         =>  'n',
    '/Ñ/'         =>  'N',
    '/–/'         =>  '-', // UTF-8 hyphen to "normal" hyphen
    '/[’‘‹›‚]/u'  =>  ' ', // Literally a single quote
    '/[“”«»„]/u'  =>  ' ', // Double quote
    '/ /'         =>  ' ', // nonbreaking space (equiv. to 0x160)
  );
  return preg_replace(array_keys($utf8), array_values($utf8), $text);
}


function checkEmail($email = '') {
  $email = make_safe($email);
  if ($email != '') {
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) { // email misspelled
      return false;
    } else {
      $email_parts = explode('@',$email);
      $email_domain = $email_parts[1];
      if (!getmxrr($email_domain, $mxrecords)) { // no mx record
        return false;
      }
    }
    return true;
  } else {
    return false;
  }
}


function ob_html_compress($buffer) {
  return preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$buffer));
}

?>