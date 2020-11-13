<?php

/**
 * Loading pages from Directus (only most important fields).
 */

foreach($directus_pages['collections'] as $key => $single_collection) {
  
  // Defining a potential slug prepend.
  $slug_add = '';
  if (isset($directus_pages['slug_depth']) and !empty($directus_pages['slug_depth'])) {
    $slug_add = $directus_pages['slug_depth'][$key] . '/';
  }

  // Determining the query.
  $field_query = 'id';
  $fields_main_level = array('slug', 'sitemap');
  $fields_sub_level = array();
  $fields_flex_level = array('view', 'name');
  foreach ($fields_main_level as $field_name) {
    if (isset($directus_pages[$field_name]) and $directus_pages[$field_name] != '') {
      $field_query .= ',' . $directus_pages[$field_name];
    }
  }
  foreach ($fields_flex_level as $field_name) {
    if (isset($directus_pages[$field_name]) and $directus_pages[$field_name] != '') {
      if ($directus_pages[$field_name][0] == '.') {
        $field_query .= ',' . $directus_pages['translation_block'] . $directus_pages[$field_name];
        array_push($fields_sub_level,$field_name);
      } else {
        $field_query .= ',' . $directus_pages[$field_name];
        array_push($fields_main_level,$field_name);
      }
    }
  }
  if (isset($directus_pages['language_field'])) $field_query .= ',' . $directus_pages['translation_block'] . '.' . $directus_pages['language_field'];

  // Draw content from Directus (or the cache, if set).
  $cache_filename = 'directus_cache_main';
  if ($directus_cache and file_exists(__DIR__ . '/../cache/' . $cache_filename . '.json')) {
    $cache_main_file = file_get_contents(__DIR__ . '/../cache/' . $cache_filename . '.json');
    $tmp_draw = json_decode($cache_main_file, true);
  } else {
    $tmp_draw = getDirectusContent($single_collection, '', '', $directus_pages['respect_status'], $field_query);
    if ($directus_cache) { // save to cache
      $fp = fopen(__DIR__ . '/../cache/' . $cache_filename . '.json', 'w');
      fwrite($fp, json_encode($tmp_draw));
      fclose($fp);
    }
  }

  // Create pages.
  if (is_array($tmp_draw)) {

    $fields_boolean = array('sitemap');
    foreach ($tmp_draw as $item) {
      // First, optimize fields, which are expected to be boolean, but are provided differently.    
      foreach ($fields_boolean as $field_name) {
        if (isset($item[$field_name])) {
          if ($item[$field_name] == '1') {
            $item[$field_name] = true;
          } elseif ($item[$field_name] == '0')  {
            $item[$field_name] = false;
          }
        }
      }

      // Read the values and create.
      $tmp_id = $slug_add . $item[$directus_pages['slug']];
      if ($tmp_id == '' or $tmp_id == '/') $tmp_id = 'main';

      $tmp_lang = $language['active'];

      if (isset($item[$directus_pages['translation_block']])) {
        foreach ($item[$directus_pages['translation_block']] as $translated_item) {
          if (isset($translated_item[$directus_pages['language_field']])) $tmp_lang = $translated_item[$directus_pages['language_field']];        
          foreach ($fields_main_level as $field_name) {
            if (isset($item[$directus_pages[$field_name]])) $pages[$tmp_lang][$tmp_id][$field_name] = $item[$directus_pages[$field_name]];
          }
          foreach ($fields_sub_level as $field_name) {
            if (isset($translated_item[substr($directus_pages[$field_name], 1)])) $pages[$tmp_lang][$tmp_id][$field_name] = $translated_item[substr($directus_pages[$field_name], 1)];
          }
          $pages[$tmp_lang][$tmp_id]['directus_collection'] = $single_collection;
          $pages[$tmp_lang][$tmp_id]['directus_id'] = $item['id'];
          $pages[$tmp_lang][$tmp_id]['directus_dyn'] = true;
        }
      } else {
        foreach ($fields_main_level as $field_name) {
          if (isset($item[$directus_pages[$field_name]])) $pages[$tmp_lang][$tmp_id][$field_name] = $item[$directus_pages[$field_name]];
        }
        $pages[$tmp_lang][$tmp_id]['directus_collection'] = $single_collection;
        $pages[$tmp_lang][$tmp_id]['directus_id'] = $item['id'];
        $pages[$tmp_lang][$tmp_id]['directus_dyn'] = true;
      }

    }

  }

}


?>
