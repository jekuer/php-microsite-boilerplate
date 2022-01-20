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
  $the_url_path['base'] = '';
  if (isset($_SERVER['SCRIPT_NAME'])) {
    $the_url_path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
  }
  $the_url_path['call_utf8'] = substr(urldecode($the_request_path[0]), strlen($the_url_path['base']) + 1);
  $the_url_path['call'] = utf8_decode($the_url_path['call_utf8']);
  if (!isset($_SERVER['PHP_SELF']) or $the_url_path['call'] == basename($_SERVER['PHP_SELF'])) {
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
    exit();
}
foreach ($url_parts_all['call_parts'] as $call_part) {
  if ($call_part != '') $url_parts[] = make_safe($call_part);
}
foreach ($url_parts_all['query_vars'] as $key => $value) {
  if ($value != '') $url_query_vars[make_safe($key)] = make_safe($value);
}

$url_parts_all_prev = array();
$url_parts_prev = array();
$prev_url_to_parse = '';
$same_site_referrer = false;
if (isset($_SERVER['HTTP_REFERER'])) {
  $prev_url_to_parse = filter_var($_SERVER['HTTP_REFERER'], FILTER_SANITIZE_URL);
  $prev_url_to_parse_arr = parse_url($prev_url_to_parse);
  if (isset($prev_url_to_parse_arr['host']) and isset($_SERVER['HTTP_HOST'])) {
    if ($_SERVER['HTTP_HOST'] == $prev_url_to_parse_arr['host'] and isset($prev_url_to_parse_arr['path'])) {
      $same_site_referrer = true;
      $prev_url_to_parse = $prev_url_to_parse_arr['path'];
      $url_parts_all_prev = parse_the_url($prev_url_to_parse);
    } else {
      $prev_url_to_parse = '';
    }
  }
  if (isset($url_parts_all_prev['call_parts'])) {
    foreach ($url_parts_all_prev['call_parts'] as $call_part) {
      if ($call_part != '') $url_parts_prev[] = make_safe($call_part);
    }
  }
}


// Also save path.
$full_url_parts = implode('/', $url_parts);
$full_url_parts_prev = implode('/', $url_parts_prev);


// Get language information and reset URL parts (current URL only).
$language['active'] = $language['default'];
if (isset($url_parts[0])) {
  foreach ($language['available'] as $lang => $lang_name) {
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


// Adjust URL variables for language adjustments.
if ($language['active'] != $language['default']) {
  $the_page_url_full .= $language['active'] . '/';
}
$the_page_url_full = filter_var($the_page_url_full, FILTER_SANITIZE_URL);
$current_url = $the_page_url_full; // update from actual URL to the current clean one
if (isset($url_parts[0])) {
  $current_url .= $url_parts[0] . '/';
}
if (isset($url_parts[1])) {
  $current_url .= $url_parts[1] . '/';
}
// Including query parameters is not recommended, but can be necessary in some cases.
/*if (isset($url_query_vars) and is_array($url_query_vars) and !empty($url_query_vars)) {
  $current_url .= '?';
  $addand = 0;
  foreach ($url_query_vars as $key => $value) {
    if ($addand == 1) $current_url .= '&';
    $current_url .= $key . '=' . $value;
    $addand = 1;
  }
}*/
$current_url = filter_var($current_url, FILTER_SANITIZE_URL);


?>