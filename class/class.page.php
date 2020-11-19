<?php

/**
 * Class to handle a specific page.
 */

class Page {
    
  public $id;
  public $slug;
  public $directus = array();
  public $view = '';
  public $controller = '';
  public $title = '';
  public $description = '';
  public $keywords = '';
  public $author = '';
  public $publisher = '';
  public $twitter = '';
  public $robots = 'index,follow';
  public $amp = false;
  
  public function __construct($page_slug, $pages, $page_defaults) {
    global $directus_pages, $directus_cache, $language;

    // find and set the id via slug
    $this->slug = $page_slug;
    $slug_override = false;
    if (is_array($pages)) {
      $tmp_search_array = array_column_ext($pages, 'slug', -1);
      $slug_override = array_search($page_slug, $tmp_search_array);
    }
    if (false !== $slug_override and $slug_override != '') {
      $this->id = $slug_override;
    } else {
      $this->id = $page_slug;
    }

    // Check for special cases.
    if (isset($pages[$this->id]) and $this->id != '') {
      $curr_page = $pages[$this->id];

      // Load Directus dyn pages details.
      if (isset($curr_page['directus_dyn']) and $curr_page['directus_dyn'] = true) {
        // Draw content from Directus (or the cache, if set).
        $cache_filename = 'directus_cache_page_' . $this->id . '_' . str_replace('/','-sub-',$this->slug) . '_' . $language['active'];
        if ($directus_cache and file_exists(__DIR__ . '/../cache/' . $cache_filename . '.json')) {
          $cache_page_file = file_get_contents(__DIR__ . '/../cache/' . $cache_filename . '.json');
          $this->directus = json_decode($cache_page_file, true);
        } else {
          $this->directus = getDirectusContent($curr_page['directus_collection'], $curr_page['directus_id'], '', false, '', true);
          if ($directus_cache) { // save to cache
            $fp = fopen(__DIR__ . '/../cache/' . $cache_filename . '.json', 'w');
            fwrite($fp, json_encode($this->directus));
            fclose($fp);
          }
        }
        // First, check where we need to look for which information.
        $fields_main_level = array('robots', 'amp', 'redirect');
        $fields_sub_level = array();
        $fields_flex_level = array('controller', 'title', 'description', 'keywords');
        foreach ($fields_flex_level as $field_name) {
          if (isset($directus_pages[$field_name]) and $directus_pages[$field_name] != '') {
            if ($directus_pages[$field_name][0] == '.') {
              $directus_pages[$field_name] = substr($directus_pages[$field_name], 1);
              array_push($fields_sub_level,$field_name);
            } else {
              array_push($fields_main_level,$field_name);
            }
          }
        }
        // Second, fill the details.
        $fields_boolean = array('amp');
        foreach ($fields_boolean as $field_name) { // Optimize boolean fields
          if (isset($this->directus[$field_name])) {
            if ($this->directus[$field_name] == '1') {
              $this->directus[$field_name] = true;
            } elseif ($this->directus[$field_name] == '0')  {
              $this->directus[$field_name] = false;
            }
          }
        }
        foreach ($fields_main_level as $field_name) {
          if (isset($this->directus[$directus_pages[$field_name]])) $curr_page[$field_name] = make_safe2($this->directus[$directus_pages[$field_name]]);
        }
        foreach ($fields_sub_level as $field_name) {
          if (isset($this->directus[$directus_pages['translation_block']][$directus_pages[$field_name]])) $curr_page[$field_name] = make_safe2($this->directus[$directus_pages['translation_block']][$directus_pages[$field_name]]);
        }
        // Third and last, unset the Directus link of the page to not call the details again later.
        unset($curr_page['directus_collection']);
        unset($curr_page['directus_id']);
        // And default view to the slug if not set.
        if (!isset($curr_page['view']) or (isset($curr_page['view']) and $curr_page['view'] == '')) {
          $curr_page['view'] = $this->directus[$directus_pages['slug']];
        }
      }

      // Check for redirect.
      if (isset($curr_page['redirect']) and $curr_page['redirect'] != '') {
        header('Location: ' . $curr_page['redirect'], true, 301);
        die();
      }
      // Mind a potential alias.
      if (isset($curr_page['alias']) and $curr_page['alias'] != '') {
        $this->id = $curr_page['alias'];
        $curr_page = $pages[$this->id]; // Redefine page to reflect the change.
      }
    } else {
      http_response_code(404);
      $this->id = 'error';
      $curr_page = $pages[$this->id]; // Redefine page to reflect the change.
    }

    // Check if a view exists.
    if (!isset($curr_page['view']) or (isset($curr_page['view']) and $curr_page['view'] == '')) {
      http_response_code(500);
      $this->id = 'error';
      $curr_page = $pages[$this->id]; // Redefine page to reflect the change.
    }

    // Define the settings.
    // Go for defaults first.
    if (isset($page_defaults['title'])) $this->title = $page_defaults['title'];
    if (isset($page_defaults['description'])) $this->description = $page_defaults['description'];
    if (isset($page_defaults['keywords'])) $this->keywords = $page_defaults['keywords'];
    if (isset($page_defaults['author'])) $this->author = $page_defaults['author'];
    if (isset($page_defaults['publisher'])) $this->publisher = $page_defaults['publisher'];
    if (isset($page_defaults['twitter'])) $this->twitter = $page_defaults['twitter'];
    if (isset($page_defaults['robots'])) $this->robots = $page_defaults['robots'];
    // Look for page specifics second.
    $this->view = $curr_page['view'];
    if (isset($curr_page['controller']) and $curr_page['controller'] != '') {
      $this->controller = $curr_page['controller'];
    }
    if (isset($curr_page['title']) and $curr_page['title'] != '') {
      $this->title = $curr_page['title'];
    }
    if (isset($curr_page['description']) and $curr_page['description'] != '') {
      $this->description = $curr_page['description'];
    }
    if (isset($curr_page['keywords']) and $curr_page['keywords'] != '') {
      $this->keywords = $curr_page['keywords'];
    }
    if (isset($curr_page['robots']) and $curr_page['robots'] != '') {
      $this->robots = $curr_page['robots'];
    }
    if (isset($curr_page['amp']) and $curr_page['amp'] == true) {
      $this->amp = true;
    }
    if (isset($curr_page['directus_collection']) and $curr_page['directus_collection'] != '' and isset($curr_page['directus_id']) and $curr_page['directus_id'] != '') {
      // Draw content from Directus (or the cache, if set).
      $cache_filename = 'directus_cache_page_' . str_replace('/','-sub-',$this->id) . '_' . $language['active'];
      if ($directus_cache and file_exists(__DIR__ . '/../cache/' . $cache_filename . '.json')) {
        $cache_page_file = file_get_contents(__DIR__ . '/../cache/' . $cache_filename . '.json');
        $this->directus = json_decode($cache_page_file, true);
      } else {
        $this->directus = getDirectusContent($curr_page['directus_collection'], $curr_page['directus_id'], '', false, '', true);
        if ($directus_cache) { // save to cache
          $fp = fopen(__DIR__ . '/../cache/' . $cache_filename . '.json', 'w');
          fwrite($fp, json_encode($this->directus));
          fclose($fp);
        }
      }      
    }

  }

}


?>