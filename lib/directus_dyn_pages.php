<?php

/**
 * Loading pages from Directus.
 */


foreach($directus_pages['collections'] as $key => $single_collection) {
  $tmp_draw = array();
  $tmp_draw = getDirectusContent($single_collection, '', '', $directus_pages['respect_status']);
  $slug_add = '';
  if (isset($directus_pages['slug_depth']) and !empty($directus_pages['slug_depth'])) {
    $slug_add = $directus_pages['slug_depth'][$key] . '/';
  }
  foreach ($tmp_draw as $item) {
    $tmp_lang = $language['active'];

    $field_query = 'id,' . $directus_pages['slug'];
    $fields_main_level = array('robots', 'amp', 'redirect', 'sitemap');
    $fields_sub_level = array();
    $fields_flex_level = array('view', 'controller', 'name', 'title', 'description', 'keywords');
    foreach ($fields_main_level as $field_name) {
      if (isset($directus_pages[$field_name]) and $directus_pages[$field_name] != '') {
        $field_query .= ',' . $directus_pages[$field_name];
      }
    }
    $field_query_sub = 'id';
    foreach ($fields_flex_level as $field_name) {
      if (isset($directus_pages[$field_name]) and $directus_pages[$field_name] != '') {
        if ($directus_pages[$field_name][0] == '.') {
          $directus_pages[$field_name] = substr($directus_pages[$field_name]);
          $field_query_sub .= ',' . $directus_pages[$field_name];
          array_push($fields_sub_level,$field_name);
        } else {
          $field_query .= ',' . $directus_pages[$field_name];
          array_push($fields_main_level,$field_name);
        }
      }
    }
    $field_query .= '.' . $field_query_sub;

    $tmp_draw_detail = getDirectusContent($single_collection, $item['id'], '', false, $field_query);

    if (isset($tmp_draw_detail['data'][$directus_pages['translation_block']][$directus_pages['language_field']])) $tmp_lang = $tmp_draw_detail['data'][$directus_pages['translation_block']][$directus_pages['language_field']];
    
    $tmp_id = $slug_add . $tmp_draw_detail['data'][$directus_pages['slug']];
    foreach ($fields_main_level as $field_name) {
      if (isset($tmp_draw_detail['data'][$directus_pages[$field_name]])) $pages[$tmp_lang][$tmp_id][$field_name] = $tmp_draw_detail['data'][$directus_pages[$field_name]]
    }
    foreach ($fields_sub_level as $field_name) {
      if (isset($tmp_draw_detail['data'][$directus_pages[$field_name]])) $pages[$tmp_lang][$tmp_id][$field_name] = $tmp_draw_detail['data'][$directus_pages['translation_block']][$directus_pages[$field_name]]
    }
    $pages[$tmp_lang][$tmp_id]['directus_collection'] = $single_collection;
    $pages[$tmp_lang][$tmp_id]['directus_id'] = $item['id'];
    if (!isset($pages[$tmp_lang][$tmp_id]['view'])) $pages[$tmp_lang][$tmp_id]['view'] = $tmp_draw_detail['data'][$directus_pages['slug']];
  }
}


?>
