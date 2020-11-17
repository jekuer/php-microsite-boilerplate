<?php

/**
 * Connecting to the Directus API.
 */

$directus_auth_token = '';

// Authenticate.
// Only if credentials are set. Not necessary, if API access to the respective information is set to public at the Directus instance.
function authDirectus($directus_url) {
  global $directus_user, $directus_password;
  $api_curl_url = $directus_url . 'auth/authenticate';
  $api_curl_headers = array(
    'Accept: application/json',
    'Content-Type: application/json'
  );
  $api_curl_params = array('email' => $directus_user, 'password' => $directus_password, 'mode' => 'cookie');
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($api_curl_params));
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($curl, CURLOPT_URL, $api_curl_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $api_curl_headers);
  curl_setopt($curl, CURLOPT_HEADER, 1);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '2');
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
  curl_setopt($curl, CURLOPT_VERBOSE, 0);
  $api_curl_response = curl_exec($curl);
  $api_curl_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  curl_close($curl);
  if ($api_curl_code == '200') {
    $matches = array();
    preg_match('/Set-Cookie:\sdirectus-' . basename($directus_url) . '-session=(.*?)\;\spath=/', $api_curl_response, $matches);
    return $matches[1];
  }
  return '';
}

// Read/Get only.
function getDirectusContent($collection, $item = '', $file = '', $respect_status = false, $get_fields = '', $filter_lang = false) {
  global $directus_auth_token, $directus_url, $directus_user, $directus_password, $directus_pages, $language;
  $directus_url = rtrim($directus_url, '/') . '/';
  $directus_url = filter_var($directus_url, FILTER_SANITIZE_URL);

  // Authenticate if credentials are set.
  if ($directus_user != '' and $directus_password != '' and $directus_auth_token == '') {
    $directus_auth_token = authDirectus($directus_url, $directus_user, $directus_password);
  }
  
  // Get the content.
  $api_curl_url = '';
  $go_for_filter_lang = false;
  if (isset($file) and $file != '') {
    // setting $file retrieves the specific file.
    // https://docs.directus.io/api/files.html#retrieve-a-file
    $api_curl_url = $directus_url . 'files/' . make_safe($file);

  } elseif (isset($collection) and $collection != '' and isset($item) and $item != '') {
    // setting $collection and $item retrieves the specific item (including related collections' fields).
    // https://docs.directus.io/api/items.html#retrieve-an-item    
    if ($get_fields != '') {
      $cq = 'fields=' . $get_fields;
    } else {
      $cq = 'fields=*.*';
    }
    if ($filter_lang) $cq .= '&lang=' . $language['active']; // V8 only!
    if ($filter_lang) $go_for_filter_lang = true;
    $api_curl_url = $directus_url . 'items/' .  make_safe($collection) . '/' .  make_safe($item) . '?' . $cq;

  } elseif (isset($collection) and $collection != '') {
    // setting $collection only retrieves a list of all items (optionally with meta elements and optionally only published ones) of this collection.
    // https://docs.directus.io/api/items.html#list-the-items
    if ($get_fields != '') {
      $cq = 'fields=' . $get_fields;
    } else {
      $cq = 'fields=id';
    }
    if ($respect_status) $cq .= '&filter[status]=published';
    $api_curl_url = $directus_url . 'items/' . make_safe($collection) . '?' . $cq;
  }
  
  if ($api_curl_url != '') {
    $api_curl_headers = array(
      'Accept: application/json',
      'Content-Type: application/json'
    );
    if ($directus_auth_token != '') {
      array_push($api_curl_headers, 'Cookie: directus-' . basename($directus_url) . '-session=' . $directus_auth_token);
    }
    $return_json = '';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $api_curl_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $api_curl_headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '2');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_VERBOSE, 0); 
    $api_curl_response = curl_exec($curl);
    $api_curl_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($api_curl_code == '200') {
      $return_json = $api_curl_response;
    }
  }
  $directus_content = json_decode($return_json, true);

  if ($go_for_filter_lang) { // kill elements, which hold a language code that does not fit the currently active language. Currently necessary for Directus V9.RC (WORKAROUND). Should be replaced by a deep-query-filter in addition to the V8-lang filter above later!!!
    foreach ($directus_content['data'] as $bucket) {
      if (is_array($bucket)) {
        foreach ($bucket as $key => $lang_block) {
          foreach ($lang_block as $name => $val) {
            if ($name = $directus_pages['language_field'] or $name = 'language' or $name = 'language_code' or $name = 'languages_code' or $name = 'language-code' or $name = 'languages-code') {
              if ($val != $language['active']) {
                unset($directus_content['data'][$key]); 
                break 2;
              }
            }
          }
        }
      }
    }
  }

  // clean up the translations array, if there is only one after a language filter.
  if ($go_for_filter_lang and isset($directus_pages['translation_block']) and $directus_pages['translation_block'] != '') {
    if (is_array($directus_content['data'][$directus_pages['translation_block']]) and count($directus_content['data'][$directus_pages['translation_block']]) == 1)
    $tmp_translations_elem = $directus_content['data'][$directus_pages['translation_block']][0];
    unset($directus_content['data'][$directus_pages['translation_block']]);
    $directus_content['data'][$directus_pages['translation_block']] = $tmp_translations_elem;
  }

  return $directus_content['data'];

}


?>