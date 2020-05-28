<?php

/**
 * Class to handle a specific page.
 */

class Page {
    
  public $id;
  public $directus = array();
  public $view = '';
  public $controller = '';
    
  public function __construct($page_id = 'error', $pages) {

    $this->id = $page_id;

    // Check for special cases.
    if (isset($pages[$this->id]) and $this->id != '') {
      $curr_page = $pages[$this->id];
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
    if (!isset($curr_page['view']) or $curr_page['view'] == '') {
      http_response_code(500);
      $this->id = 'error';
      $curr_page = $pages[$this->id]; // Redefine page to reflect the change.
    }

    // Define the settings.
    $this->view = $curr_page['view'];
    if (isset($curr_page['controller']) and $curr_page['controller'] != '') {
      $this->controller = $curr_page['controller'];
    }
    if (isset($curr_page['title']) and $curr_page['title'] != '') {
      $GLOBALS['the_page_title'] = $curr_page['title'];
    }
    if (isset($curr_page['description']) and $curr_page['description'] != '') {
      $GLOBALS['the_page_description'] = $curr_page['description'];
    }
    if (isset($curr_page['keywords']) and $curr_page['keywords'] != '') {
      $GLOBALS['the_meta_keywords'] = $curr_page['keywords'];
    }
    if (isset($curr_page['robots']) and $curr_page['robots'] != '') {
      $GLOBALS['the_robots_rules'] = $curr_page['robots'];
    }
    if (!isset($curr_page['amp']) or $curr_page['amp'] == false) {
      $GLOBALS['amp'] = false;
    }
    if (isset($curr_page['directus_collection']) and $curr_page['directus_collection'] != '' and isset($curr_page['directus_id']) and $curr_page['directus_id'] != '') {
      $this->directus = json_decode(getDirectusContent($curr_page['directus_collection'], $curr_page['directus_id']), true);
    }

  }

}


?>