<?php

/**
 * Connecting to the Directus API.
 */

$directus_url = rtrim($directus_url, '/') . '/';
$directus_url = filter_var($directus_url, FILTER_SANITIZE_URL);
if ($directus_version == '8') { // fixing path for V8
  $directus_url .= $directus_project .'/';
}
$directus_auth_token = '';

// Authenticate.
// Only if credentials are set. Not necessary, if API access to the respective information is set to public at the Directus instance.
function authDirectus($directus_url) {
  global $directus_user, $directus_password, $directus_version, $directus_project;
  if ($directus_version == '8') {
    $api_curl_url = $directus_url . 'auth/authenticate';
  } else {
    $api_curl_url = $directus_url . 'auth/login';
  }
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
  if ($directus_version == '8') curl_setopt($curl, CURLOPT_HEADER, 1);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '2');
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
  curl_setopt($curl, CURLOPT_VERBOSE, 0);
  $api_curl_response = curl_exec($curl);
  $api_curl_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  curl_close($curl);
  if ($api_curl_code == '200') {
    $matches = array();
    if ($directus_version == '8') {
      preg_match('/Set-Cookie:\sdirectus-' . $directus_project . '-session=(.*?)\;/i', $api_curl_response, $matches);
    } else {
      //preg_match('/Set-Cookie:\sdirectus_refresh_token=(.*?)\;/i', $api_curl_response, $matches); // Would retrieve the refresh token. We keep it simple in this application and only work with the access token.
      $tmp_response = json_decode($api_curl_response, true);
      $matches[1] = $tmp_response['data']['access_token'];
    }
    if (isset($matches[1]) and $matches[1] != '') {
      return $matches[1];
    } else {
      die ('Authentication failed. Response: ' . $api_curl_response);
    }
  } else {
    die('CMS authentication failed. Error: ' . $api_curl_code);
  }
}


// Read/Get only.
function getDirectusContent($collection, $item = '', $file = '', $respect_status = false, $get_fields = '', $filter_lang = false) {
  global $directus_auth_token, $directus_url, $directus_user, $directus_password, $directus_pages, $directus_version, $directus_project, $directus_cache, $language;

  // Check for cache first.
  $cache_token = md5($collection . '_' . $item . '_' . $file . '_' . $respect_status . '_' . $get_fields . '_' . $filter_lang);
  if ($filter_lang) {
    $cache_filename = 'directus_cache_' . $collection . '_' . $item . '_' . $cache_token . '_' . $language['active'];
  } else {
    $cache_filename = 'directus_cache_' . $collection . '_' . $item . '_' . $cache_token;
  }
  if ($directus_cache and file_exists(__DIR__ . '/../cache/' . $cache_filename . '.json')) {
    $cache_page_file = file_get_contents(__DIR__ . '/../cache/' . $cache_filename . '.json');
    return json_decode($cache_page_file, true);
  }

  // Authenticate if credentials are set.
  if ($directus_user != '' and $directus_password != '' and $directus_auth_token == '') {
    $directus_auth_token = authDirectus($directus_url, $directus_user, $directus_password);
  }
  
  // Get the content.
  $api_curl_url = '';
  $clean_up_filter_lang = false;
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
    if ($respect_status) $cq .= '&filter[status]=published';
    if ($filter_lang) {
      if ($directus_version == '8') {
        $cq .= '&lang=' . $language['directus'][$language['active']]; // V8 only!
      } else {
        if (!isset($directus_pages['translation_block']) or (isset($directus_pages['translation_block']) and $directus_pages['translation_block'] == '')) $directus_pages['translation_block'] = 'translations'; // set defaults if not provided
        if (!isset($directus_pages['language_field']) or (isset($directus_pages['language_field']) and $directus_pages['language_field'] == '')) $directus_pages['language_field'] = 'languages_code'; // set defaults if not provided
        $translation_block_str = str_replace(" ", "%20", $directus_pages['translation_block']);
        $language_field_str = str_replace(" ", "%20", $directus_pages['language_field']);
        $cq .= '&deep[' . $translation_block_str . '][_filter][' . $language_field_str . '][_eq]=' . $language['directus'][$language['active']]; // V9
      }
      $clean_up_filter_lang = true;
    }
    $api_curl_url = $directus_url . 'items/' .  make_safe($collection) . '/' .  make_safe($item) . '?' . $cq . '&limit=-1';

  } elseif (isset($collection) and $collection != '') {
    // setting $collection only retrieves a list of all items (optionally with meta elements and optionally only published ones) of this collection.
    // https://docs.directus.io/api/items.html#list-the-items
    if ($get_fields != '') {
      $cq = 'fields=' . $get_fields;
    } else {
      $cq = 'fields=id';
    }
    if ($filter_lang) {
      if ($directus_version == '8') {
        $cq .= '&lang=' . $language['directus'][$language['active']]; // V8 only!
      } else {
        if (!isset($directus_pages['translation_block']) or (isset($directus_pages['translation_block']) and $directus_pages['translation_block'] == '')) $directus_pages['translation_block'] = 'translations'; // set defaults if not provided
        if (!isset($directus_pages['language_field']) or (isset($directus_pages['language_field']) and $directus_pages['language_field'] == '')) $directus_pages['language_field'] = 'languages_code'; // set defaults if not provided
        $translation_block_str = str_replace(" ", "%20", $directus_pages['translation_block']);
        $language_field_str = str_replace(" ", "%20", $directus_pages['language_field']);
        $cq .= '&deep[' . $translation_block_str . '][_filter][' . $language_field_str . '][_eq]=' . $language['directus'][$language['active']]; // V9
      }
      $clean_up_filter_lang = true;
    }
    if ($respect_status) $cq .= '&filter[status]=published';
    $api_curl_url = $directus_url . 'items/' . make_safe($collection) . '?' . $cq . '&limit=-1';
  }
  
  if ($api_curl_url != '') {
    $api_curl_headers = array(
      'Accept: application/json',
      'Content-Type: application/json'
    );
    if ($directus_auth_token != '') {
      if ($directus_version == '8') {
        array_push($api_curl_headers, 'Cookie: directus-' . $directus_project . '-session=' . $directus_auth_token);
      } else {
        // array_push($api_curl_headers, 'Cookie: directus_refresh_token=' . $directus_auth_token); // Would set the refresh token. We keep it simple in this application and only work with the access token.
        array_push($api_curl_headers, 'Authorization: Bearer ' . $directus_auth_token);
      }
    } else {
      die('Something went wrong. Not authenticated.');
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
    } else {
      die('Error retrieving CMS data. Error Code: ' . $api_curl_code . ' (Call: ' . $api_curl_url . ') (Response: ' . $api_curl_response . ')');
    }
  }
  $directus_content = json_decode($return_json, true);

  // clean up the translations array, if there is only one after a language filter.
  if ($clean_up_filter_lang and isset($directus_pages['translation_block']) and isset(($directus_content['data'][$directus_pages['translation_block']])) and $directus_pages['translation_block'] != '') {
    if (is_array($directus_content['data'][$directus_pages['translation_block']]) and count($directus_content['data'][$directus_pages['translation_block']]) == 1) {
      $directus_content['data'][$directus_pages['translation_block']] = array_values($directus_content['data'][$directus_pages['translation_block']]);
      $tmp_translations_elem = $directus_content['data'][$directus_pages['translation_block']][0];
      unset($directus_content['data'][$directus_pages['translation_block']]);
      $directus_content['data'][$directus_pages['translation_block']] = $tmp_translations_elem;
    }
  }

  // write to cache and return.
  if ($directus_cache) {
    $fp = fopen(__DIR__ . '/../cache/' . $cache_filename . '.json', 'w');
    fwrite($fp, json_encode($directus_content['data']));
    fclose($fp);
  }

  return $directus_content['data'];

}


?>