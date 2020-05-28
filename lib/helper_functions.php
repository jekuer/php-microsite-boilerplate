<?php

/**
 * Some handy functions.
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