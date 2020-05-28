<?php

/**
 * Connecting to the Directus API.
 */

// Authenticate.
// Only if credentials are set. Not necessary, if API access to the respective information is set to public at the Directus instance.
function authDirectus() {
    $api_curl_url = rtrim($GLOBALS['directus_url'], '/') . '/auth/authenticate';
    $api_curl_headers = array(
      'Accept: application/json',
      'Content-Type: application/json'
    );
    $api_curl_params = array('email' => $GLOBALS['directus_user'], 'password' => $GLOBALS['directus_password'], 'mode' => 'cookie');
    $return_json = '';
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
      preg_match('/Set-Cookie:\sdirectus-' . basename($GLOBALS['directus_url']) . '-session=(.*?)\;\spath=/', $api_curl_response, $matches);
      return $matches[1];
    }
  return '';
}

// Read/Get only.
function getDirectusContent($collection, $item = '', $file = '') {

  // Authenticate if credentials are set.
  $auth_token = '';
  if ($GLOBALS['directus_user'] != '' and $GLOBALS['directus_password'] != '') {
    $auth_token = authDirectus();
  }
  
  // Get the content.
  $api_curl_url = '';
  if (isset($file) and $file != '') {
    // setting $file retrieves the specific file.
    // https://docs.directus.io/api/files.html#retrieve-a-file
    $api_curl_url = rtrim($GLOBALS['directus_url'], '/') . '/files/' . make_safe($file);

  } elseif (isset($collection) and $collection != '' and isset($item) and $item != '') {
    // setting $collection and $item retrieves the specific item.
    // https://docs.directus.io/api/items.html#retrieve-an-item
    $api_curl_url = rtrim($GLOBALS['directus_url'], '/') . '/items/' .  make_safe($collection) . '/' .  make_safe($item);

  } elseif (isset($collection) and $collection != '') {
    // setting $collection only retrieves a list of all items (without details, change to retrieve more) of this collection.
    // https://docs.directus.io/api/items.html#list-the-items
    $api_curl_url = rtrim($GLOBALS['directus_url'], '/') . '/items/' . make_safe($collection) . '?fields=id';

  }
  
  if ($api_curl_url != '') {
    $api_curl_headers = array(
      'Accept: application/json',
      'Content-Type: application/json'
    );
    if ($auth_token != '') {
      array_push($api_curl_headers, 'Cookie: directus-' . basename($GLOBALS['directus_url']) . '-session=' . $auth_token);
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
  return $return_json;
}


?>