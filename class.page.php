<?php

/**
 * Class to handle a specific page.
 */

class Page {
    
  public $id;
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
  
  public function __construct($page_id, $pages, $page_defaults) {

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
      $this->directus = json_decode(getDirectusContent($curr_page['directus_collection'], $curr_page['directus_id']), true);
    }

  }

}


?>