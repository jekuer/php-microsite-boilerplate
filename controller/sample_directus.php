<?php

$directus_page_content = '';

// requires the mentioned item (as defined within routing.php) owns a field "content".
$directus_page_content = $the_page->directus['data']['content'];

if ($directus_page_content != '') {
  $directus_page_content = '<p>&nbsp;</p><p>Look, we got some content!</p><p>&nbsp;</p>' . $directus_page_content
}

?>