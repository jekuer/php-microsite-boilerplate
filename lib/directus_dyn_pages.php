<?php

/**
 * Loading pages from Directus (only most important fields).
 */

foreach($directus_pages['collections'] as $key => $single_collection) {

  // Defining a potential slug prepend.
  $slug_add = '';
  if (isset($directus_pages['slug_depth'])) {
    if (is_array($directus_pages['slug_depth']) and isset($directus_pages['slug_depth'][$key]) and $directus_pages['slug_depth'][$key] != '') {
      $slug_add = $directus_pages['slug_depth'][$key] . '/';
    } elseif (!is_array($directus_pages['slug_depth']) and $directus_pages['slug_depth'] != '') {
      $slug_add = $directus_pages['slug_depth'] . '/';
    }
  }

  // Determining the query.
  $field_query = 'id';
  $fields_main_level = array();
  $fields_sub_level = array();
  $fields_flex_level = array('slug', 'view', 'name', 'sitemap', 'date_updated');
  $translation_block_str = '';
  if (isset($directus_pages['translation_block'])) $translation_block_str = str_replace(" ", "%20", $directus_pages['translation_block']);
  $language_field_str = '';
  if (isset($directus_pages['language_field'])) $language_field_str = str_replace(" ", "%20", $directus_pages['language_field']);
  foreach ($fields_main_level as $field_name) {
    if (isset($directus_pages[$field_name])) {
      if (is_array($directus_pages[$field_name]) and !empty($directus_pages[$field_name])) {
        $field_name_item = $directus_pages[$field_name][$key];
      } else {
        $field_name_item = $directus_pages[$field_name];
      }
      if ($field_name_item != '') $field_query .= ',' . $field_name_item;
    }
  }
  foreach ($fields_flex_level as $field_name) {
    if (isset($directus_pages[$field_name])) {
      if (is_array($directus_pages[$field_name]) and !empty($directus_pages[$field_name])) {
        $field_name_item = $directus_pages[$field_name][$key];
      } else {
        $field_name_item = $directus_pages[$field_name];
      }
      if ($field_name_item != '') {
        if ($field_name_item[0] == '.') {
          $field_query .= ',' . $translation_block_str . $field_name_item;
          array_push($fields_sub_level,$field_name);
        } else {
          $field_query .= ',' . $field_name_item;
          array_push($fields_main_level,$field_name);
        }
      }
    }
  }
  if (isset($directus_pages['language_field'])) $field_query .= ',' . $translation_block_str . '.' . $language_field_str;

  // Draw content from Directus.
  $tmp_draw = getDirectusContent($single_collection, '', '', $directus_pages['respect_status'], $field_query);

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
      $tmp_id = $single_collection . '-' . $item['id'];

      $tmp_lang = $language['active'];

      if (isset($item[$directus_pages['translation_block']])) {
        foreach ($item[$directus_pages['translation_block']] as $translated_item) {
          if (isset($translated_item[$directus_pages['language_field']])) {
            $tmp_lang = make_safe($translated_item[$directus_pages['language_field']]);
            $lang_key = array_keys($language['directus'], $tmp_lang);
            $tmp_lang = $lang_key[0];
          }
          foreach ($fields_main_level as $field_name) {
            if (is_array($directus_pages[$field_name]) and !empty($directus_pages[$field_name])) {
              $field_name_item = make_safe3($directus_pages[$field_name][$key]);
            } else {
              $field_name_item = make_safe3($directus_pages[$field_name]);
            }
            if (isset($item[$field_name_item])) $pages[$tmp_lang][$tmp_id][$field_name] = $item[$field_name_item];
          }
          foreach ($fields_sub_level as $field_name) {
            if (is_array($directus_pages[$field_name]) and !empty($directus_pages[$field_name])) {
              $field_name_item = $directus_pages[$field_name][$key];
            } else {
              $field_name_item = $directus_pages[$field_name];
            }
            if (isset($translated_item[substr($field_name_item, 1)])) {
              $pages[$tmp_lang][$tmp_id][$field_name] = $translated_item[substr($field_name_item, 1)];
              $pages[$tmp_lang][$tmp_id][$field_name] = make_safe3($pages[$tmp_lang][$tmp_id][$field_name]);
            }
          }
          $pages[$tmp_lang][$tmp_id]['directus_collection'] = $single_collection;
          $pages[$tmp_lang][$tmp_id]['directus_collection_key'] = $key;
          $pages[$tmp_lang][$tmp_id]['directus_id'] = $item['id'];
          $pages[$tmp_lang][$tmp_id]['directus_dyn'] = true;
          if (isset($pages[$tmp_lang][$tmp_id]['slug'])) {
            $pages[$tmp_lang][$tmp_id]['slug'] = $slug_add . $pages[$tmp_lang][$tmp_id]['slug'];
            if ($pages[$tmp_lang][$tmp_id]['slug'] == '' or $pages[$tmp_lang][$tmp_id]['slug'] == '/') $pages[$tmp_lang][$tmp_id]['slug'] = 'main';
          }
        }
      } else {
        foreach ($fields_main_level as $field_name) {
          if (is_array($directus_pages[$field_name]) and !empty($directus_pages[$field_name])) {
            $field_name_item = make_safe3($directus_pages[$field_name][$key]);
          } else {
            $field_name_item = make_safe3($directus_pages[$field_name]);
          }
          if (isset($item[$field_name_item])) $pages[$tmp_lang][$tmp_id][$field_name] = $item[$field_name_item];
        }
        $pages[$tmp_lang][$tmp_id]['directus_collection'] = $single_collection;
        $pages[$tmp_lang][$tmp_id]['directus_collection_key'] = $key;
        $pages[$tmp_lang][$tmp_id]['directus_id'] = $item['id'];
        $pages[$tmp_lang][$tmp_id]['directus_dyn'] = true;
        if (isset($pages[$tmp_lang][$tmp_id]['slug'])) {
          $pages[$tmp_lang][$tmp_id]['slug'] = $slug_add . $pages[$tmp_lang][$tmp_id]['slug'];
          if ($pages[$tmp_lang][$tmp_id]['slug'] == '' or $pages[$tmp_lang][$tmp_id]['slug'] == '/') $pages[$tmp_lang][$tmp_id]['slug'] = 'main';
        }
      }

    }

  }

}


?>
