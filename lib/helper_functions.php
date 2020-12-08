<?php

/**
 * Language Switcher.
 */
$language_switcher_count = 0;

function create_language_switcher($page_id, $amp_version = false) {
  global $language, $pages, $language_switcher_count;
  $language_switcher = '';
  $translated_pages_count = 0;
  $lang_menu = '';
  $goto_lang = '';
  $slug = '';
  $tabindexcount = 81;
  foreach ($language['available'] as $lang => $lang_name) { // Count translated pages and prepare list.
    if (!isset($pages[$lang][$page_id]['view'])) continue;
    $translated_pages_count++;
    if ($lang != $language['active']) $goto_lang = $lang;
    if ($lang == $language['active']) {
      $lang_menu .= '<span class="lang_menu_item_active">' . $lang_name . '</span>';
    } else {
      if (isset($pages[$lang][$page_id]['slug']) and $pages[$lang][$page_id]['slug'] != '') {
        $slug = $pages[$lang][$page_id]['slug'];
      } else {
        $slug = $page_id;
      }
      if ($slug != 'main') {
        $slug = $slug . '/';
      } else {
        $slug = '';
      }
      if ($language['default'] != $lang) $slug = $lang . '/' . $slug;
      $tabindexcount++;
      $lang_menu .= '<a class="lang_menu_item" tabindex="' . $tabindexcount . '" href="';
      if ($amp_version) $lang_menu .= '/amp';
      $lang_menu .= '/' . $slug . '">' . $lang_name . '</a>';
    }
  }
  $globe_svg = '<svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" preserveAspectRatio="xMidYMid meet" image-rendering="optimizeQuality" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" viewBox="0 0 511.99997 512"><path fill="#fff" d="M 256,0 C 114.508,0 0,114.497 0,256 0,397.492 114.497,512 256,512 397.492,512 511.99997,397.503 511.99997,256 511.99997,114.508 397.503,0 256,0 Z m -99.054,52.753 c -7.747,21.099 -14.25,42.547 -19.499,64.295 -15.341,-4.661 -30.432,-10.25 -45.243,-16.762 18.754,-19.703 40.608,-35.746 64.742,-47.533 z M 72.338,124.24 c 19.171,8.878 38.791,16.3 58.802,22.253 -5.806,30.993 -9.126,62.538 -9.914,94.507 H 30.502 c 2.763,-42.441 17.226,-82.61 41.836,-116.76 z m 0,263.52 C 47.728,353.61 33.265,313.441 30.502,271 h 90.724 c 0.788,31.969 4.108,63.514 9.914,94.507 -20.011,5.953 -39.63,13.375 -58.802,22.253 z m 19.866,23.955 c 14.811,-6.513 29.901,-12.102 45.243,-16.762 5.25,21.748 11.752,43.196 19.499,64.295 -24.122,-11.781 -45.978,-27.821 -64.742,-47.533 z M 241,481.498 c -15.754,-1.025 -31.197,-3.655 -46.135,-7.825 C 183,445.553 173.53,416.721 166.467,387.31 c 24.318,-5.437 49.199,-8.616 74.533,-9.515 z m 0,-133.721 c -27.448,0.907 -54.405,4.307 -80.751,10.175 -5.234,-28.529 -8.25,-57.55 -9.013,-86.952 H 241 Z M 241,241 h -89.764 c 0.763,-29.402 3.779,-58.423 9.013,-86.952 26.346,5.868 53.303,9.268 80.751,10.175 z m 0,-106.795 c -25.334,-0.899 -50.215,-4.078 -74.533,-9.515 7.063,-29.411 16.533,-58.243 28.398,-86.363 14.938,-4.17 30.381,-6.8 46.135,-7.825 z m 198.66197,-9.965 c 24.61,34.15 39.073,74.319 41.836,116.76 H 390.774 c -0.788,-31.969 -4.108,-63.514 -9.914,-94.507 20.011,-5.953 39.62997,-13.375 58.80197,-22.253 z m -19.866,-23.955 C 404.985,106.798 389.895,112.387 374.553,117.047 369.303,95.299 362.801,73.851 355.054,52.752 c 24.122,11.781 45.978,27.821 64.74197,47.533 z M 271,30.502 c 15.754,1.025 31.197,3.655 46.135,7.825 11.865,28.12 21.335,56.952 28.398,86.363 -24.318,5.437 -49.199,8.616 -74.533,9.515 z m 0,133.721 c 27.448,-0.907 54.405,-4.307 80.751,-10.175 5.234,28.529 8.25,57.55 9.013,86.952 H 271 Z m 46.134,309.449 c -14.937,4.171 -30.38,6.801 -46.134,7.826 V 377.795 c 25.334,0.899 50.215,4.078 74.533,9.515 -7.064,29.411 -16.533,58.243 -28.399,86.362 z M 271,347.777 V 271 h 89.764 c -0.763,29.402 -3.779,58.423 -9.013,86.952 -26.346,-5.868 -53.303,-9.268 -80.751,-10.175 z m 84.054,111.47 c 7.747,-21.099 14.25,-42.547 19.499,-64.295 15.341,4.661 30.432,10.25 45.24297,16.762 C 401.042,431.417 379.188,447.46 355.054,459.247 Z m 84.60797,-71.487 c -19.171,-8.878 -38.79097,-16.3 -58.80197,-22.253 5.806,-30.993 9.126,-62.538 9.914,-94.507 h 90.72397 c -2.763,42.441 -17.226,82.61 -41.836,116.76 z"></svg>';
  $close_svg = '<svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" preserveAspectRatio="xMidYMid meet" image-rendering="optimizeQuality" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" viewBox="0 0 329.26933 329"><path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"/></svg>';
  if (count($language['available']) == 2 and $translated_pages_count == 2 ) { // If there are exactly 2 language generally and specifically for this page available, offer a direct change option.
    $language_switcher = '<a href="/' . $slug . '" class="language_switcher">' . $globe_svg . $language['available'][$goto_lang] . '&nbsp;&#9656;</a>';
  }
  if (count($language['available']) > 2 and $translated_pages_count > 1) { // If there are more than 2 language generally available and at least one additional version of the current page, offer a more complex menu.
    if ($amp_version) {
      $language_switcher = '<span class="language_switcher" on="tap:lang_menu.show" role="button" tabindex="80">' . $globe_svg . $language['available'][$language['active']] . '&nbsp;&#9662;</span>';
      if ($language_switcher_count == 0) $language_switcher .= '<span id="lang_menu" hidden><span id="lang_menu_overlay" on="tap:lang_menu.hide" role="img" tabindex="200"></span><span id="lang_menu_banner"><span id="lang_menu_close" on="tap:lang_menu.hide" role="button" tabindex="81">' . $close_svg . '</span>' . $lang_menu . '</span></span>';
    } else {
      $language_switcher = '<span class="language_switcher" onClick="document.getElementById(\'lang_menu\').style.display=\'block\';">' . $globe_svg . $language['available'][$language['active']] . '&nbsp;&#9662;</span>';
      if ($language_switcher_count == 0) $language_switcher .= '<span id="lang_menu"><span id="lang_menu_overlay" onClick="document.getElementById(\'lang_menu\').style.display=\'none\';"></span><span id="lang_menu_banner"><span id="lang_menu_close" onClick="document.getElementById(\'lang_menu\').style.display=\'none\';">' . $close_svg . '</span>' . $lang_menu . '</span></span>';
    }
  }
  $language_switcher_count++;
  return $language_switcher;
}


/**
 * Function to make it possible searching through multidimensional arrays without losing key values.
 */

function array_column_ext($array, $columnkey, $indexkey = null) {
    $result = array();
    foreach ($array as $subarray => $value) {
        if (array_key_exists($columnkey,$value)) { $val = $array[$subarray][$columnkey]; }
        else if ($columnkey === null) { $val = $value; }
        else { continue; }
           
        if ($indexkey === null) { $result[] = $val; }
        elseif ($indexkey == -1 || array_key_exists($indexkey,$value)) {
            $result[($indexkey == -1)?$subarray:$array[$subarray][$indexkey]] = $val;
        }
    }
    return $result;
}


 /**
 * Some more handy functions.
 */

function make_safe($v) { // strip html code, remove spaces, remove any special characters and more
  if (is_array($v)) {
    foreach ($v as $key => $subv) {
      $v[$key] = cleanString($subv);
      if (get_magic_quotes_gpc()) $v[$key] = stripslashes($v[$key]);
      $v[$key] = preg_replace('/[^A-Za-z0-9@&+;,:_\. -]/', '', $v[$key]);
      $v[$key] = htmlentities($v[$key], ENT_QUOTES);
      $v[$key] = strip_tags($v[$key]);
      $v[$key] = str_replace(" ", "", $v[$key]);
    }
  } else {
    $v = cleanString($v);
    if (get_magic_quotes_gpc()) $v = stripslashes($v);
    $v = preg_replace('/[^A-Za-z0-9@&+;,:_\. -]/', '', $v);
    $v = htmlentities($v, ENT_QUOTES);
    $v = strip_tags($v);
    $v = str_replace(" ", "", $v);
  }
  return $v;
}


function make_safe2($v) { // keeps spaces (except beginning and end) and allows special characters
  if (is_array($v)) {
    foreach ($v as $key => $subv) {
      $v[$key] = cleanString($subv);
      if (get_magic_quotes_gpc()) $v[$key] = stripslashes($v[$key]);
      $v[$key] = preg_replace('/[^\p{L}0-9@&+|%$§€()=?!^°#;,:_\. -]/', '', $v[$key]);
      $v[$key] = htmlentities($v[$key], ENT_QUOTES);
      $v[$key] = strip_tags($v[$key]);
      $v[$key] = trim($v[$key]);
    }
  } else {
    $v = cleanString($v);
    if (get_magic_quotes_gpc()) $v = stripslashes($v);
    $v = preg_replace('/[^\p{L}0-9@&+|%$§€()=?!^°#;,:_\. -]/', '', $v);
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