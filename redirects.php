<?php

/**
 * Defining slugs, which directly redirect to another target.
 * There is another additional option for redirects within the routing itself. This one is thought for redirects, if an existing page goes offline.
 * Use the option here if you initially want to redirect specific paths - e.g. after a migration.
 * Mind that those redirects get checked only if there is no respective active page!
 */

 // All redirects.
 $redirects = array();


 /* Example:
 $slug = 'de/subdir/my-sample-page'; // Mind to not have a slash at the beginning and end of the string. Also add a possible language information here - it really needs to be the full path!
 $redirects[$slug]['target'] = 'https://www.google.com';
 $redirects[$slug]['type'] = 301;
 */


?>
