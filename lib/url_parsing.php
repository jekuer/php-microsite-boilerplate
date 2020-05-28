<?php

/**
 * Function AND process to analyse the page path and draw respective conclusions
 */

// Function to parse the URL (requires that all calls are send through index.php!)
function parse_the_url($url) {
  $the_url_path = array();
  $the_url_path['call_parts'] = array();
  $the_url_path['query_vars'] = array();
  $the_request_path = explode('?', $url);
  $the_url_path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
  $the_url_path['call_utf8'] = substr(urldecode($the_request_path[0]), strlen($the_url_path['base']) + 1);
  $the_url_path['call'] = utf8_decode($the_url_path['call_utf8']);
  if ($the_url_path['call'] == basename($_SERVER['PHP_SELF'])) {
    $the_url_path['call'] = '';
  }
  $the_url_path['call_parts'] = explode('/', $the_url_path['call']);
  if (isset($the_request_path[1])) {
    $the_url_path['query_utf8'] = urldecode($the_request_path[1]);
    $the_url_path['query'] = utf8_decode(urldecode($the_request_path[1]));
    $url_query_vars = explode('&', $the_url_path['query']);
    foreach ($url_query_vars as $var) {
      if ($var != '') {
        $t = explode('=', $var);
        if (isset($t[0]) and isset($t[1])) $the_url_path['query_vars'][$t[0]] = $t[1];
      }
    }
  }
  return $the_url_path;
}


// Actually parse the current and previous URL.
$url_parts_all = array();
$url_parts = array();
$url_query_vars = array();
if (isset($_SERVER['REQUEST_URI'])) {
  $url_parts_all = parse_the_url($current_url);
} else {
    die();
}
foreach ($url_parts_all['call_parts'] as $call_part) {
  if ($call_part != '') $url_parts[] = make_safe($call_part);
}
foreach ($url_parts_all['query_vars'] as $key => $value) {
  if ($value != '') $url_query_vars[make_safe($key)] = make_safe($value);
}

$url_parts_all_prev = array();
$url_parts_prev = array();
if (isset($_SERVER['HTTP_REFERER'])) {
  $prev_url_to_parse = $_SERVER['HTTP_REFERER'];
  $prev_url_to_parse_arr = parse_url($prev_url_to_parse);
  if (isset($prev_url_to_parse_arr['host'])) {
    if ($_SERVER['HTTP_HOST'] == $prev_url_to_parse_arr['host'] and isset($prev_url_to_parse_arr['path'])) {
      $prev_url_to_parse = $prev_url_to_parse_arr['path'];
      $url_parts_all_prev = parse_the_url($prev_url_to_parse);
    }
  }
  if (isset($url_parts_all_prev['call_parts'])) {
    foreach ($url_parts_all_prev['call_parts'] as $call_part) {
      if ($call_part != '') $url_parts_prev[] = make_safe($call_part);
    }
  }
}


// Get AMP information and reset URL parts (current URL only).
if (isset($url_parts[0]) and $url_parts[0] == 'amp') {
  $amp = true;
  // reset URL parts.
  if (isset($url_parts[1])) {
    for ($i = 1; $i < count($url_parts); $i++) {
      $url_parts[$i - 1] = $url_parts[$i];
      if ($i == count($url_parts) - 1) unset($url_parts[$i]);
    }
  } else {
    unset($url_parts[0]);
  }
}


// Get language information and reset URL parts (current URL only).
$language['active'] = $language['default'];
if (isset($url_parts[0])) {
  foreach ($language['available'] as $lang) {
    if ($url_parts[0] == $lang) {
      $language['active'] = $lang;
      // reset URL parts.
      if (isset($url_parts[1])) {
        for ($i = 1; $i < count($url_parts); $i++) {
          $url_parts[$i - 1] = $url_parts[$i];
          if ($i == count($url_parts) - 1) unset($url_parts[$i]);
        }
      } else {
        unset($url_parts[0]);
      }
      break;
    }
  }
}


// Adjust URL variables for AMP and language adjustments.
if ($amp) $the_page_url_full = rtrim($the_page_url_full, '/') . '/amp';
$amp_url = rtrim($the_page_url, '/') . '/amp';
if ($language['active'] != $language['default']) {
  $the_page_url_full = rtrim($the_page_url_full, '/') . '/' . $language['active'];
  $amp_url .= '/' . $language['active'];
}
$current_url = $the_page_url_full; // update from actual URL to the current clean one
if (isset($url_parts[0])) {
  $current_url = rtrim($current_url, '/') . '/' . $url_parts[0];
  $amp_url .= '/' . $url_parts[0];
}


?>