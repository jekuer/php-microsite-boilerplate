<?php

$directus_page_content = '';

// requires the mentioned item (as defined within routing.php) owns a field "content".
$directus_page_content = $the_page->directus['translations']['content'];

if ($directus_page_content != '') {
  $directus_page_content = '<p>&nbsp;</p><p>Look, we got some content!</p><p>&nbsp;</p>' . $directus_page_content;
}


// OR load an additional Directus collection independently from the defined pages.

/* parameters of getDirectusContent:
   - $collection: name of the collection
   - $item: name of a specific item (optional; only if you want to GET this item; requires a collection to be set)
   - $file: name of a specific file (optional; only if you want to GET this file; leave collection and item empty in that case)
   - $respect_status_ whether to respect the status. Default = false. If set true, we will look for a field called status and only consider items, which are 'published'. If there is an environment variable 'APPSETTING_ENV' set, which says 'test', it would also consider the status 'draft'.
   - $get_fields: option to  define which fields you want to get. Default would only get the ids of the items. For example, use '*.*' to get all fields and sub-fields.
   - $filter_lang: option to filter for language. If set to true, it would only return translated nested elements at the current language. Default is false and returns all elements (all languages).
   - $filter_id: if you know the exact id of the item, you can place it here and you will only see this exact item. In contrast to directly setting the item, here you can also define multiple ones (e.g. '3,6,7').
*/

$another_directus_collection = array();
$another_directus_collection = getDirectusContent('another_collection', '', '', true, '*', true, '');

?>