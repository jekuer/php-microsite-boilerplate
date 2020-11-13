<?php

/**
 * Defining slugs, which directly redirect to another target.
 * There is another additional option for redirects within the routing itself. This one is thought for redirects, if an existing page goes offline.
 * Use the option here if you initially want to redirect specific paths - e.g. after a migration.
 */

 // All redirects.
$redirects = array();
// Mind to put pages per language, even if you only have one language. Use the language code as it is used as key at config.php
// Use the same slug per language for the same page.
foreach ($language['available'] as $lang => $lang_name) {
  $redirects[$lang] = array();
}


/* Example:
$slug = 'my-sample-page';
$redirects['en'][$slug]['target'] = 'https://www.google.com';
*/


?>
