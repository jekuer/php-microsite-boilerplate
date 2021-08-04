<?php

// Set Security Headers.
// For testing and more details, see https://securityheaders.com/ .
header("X-Frame-Options: sameorigin");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Access-Control-Allow-Origin: ". $the_page_url);
// Adjust to your needs. GET should be enough for simple landingpages. Sometimes, you might need 'GET, POST'.
header("Access-Control-Allow-Methods: GET");
// Be careful here. Enabling it limits you on what third-party tools you can include on your page. The provided configuration is only an example.
header("Content-Security-Policy: default-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.youtube-nocookie.com https://www.googletagmanager.com https://tagmanager.google.com https://stats.g.doubleclick.net https://www.google-analytics.com https://cookiehub.net data:; img-src 'self' https://www.gstatic.com https://ssl.gstatic.com https://i.ytimg.com https://stats.g.doubleclick.net https://www.google-analytics.com data:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://tagmanager.google.com https://www.google-analytics.com https://cookiehub.net");
// Usually, you would not need any special browser features, so keep them set to 'none'. Some none intrusive things might be helpful for services like YouTube.
header("Feature-Policy: geolocation 'none'; midi 'none'; sync-xhr 'none'; microphone 'none'; camera 'none'; magnetometer 'none'; gyroscope *; accelerometer *; encrypted-media *; usb 'none'; payment 'none'");
// Try to hide the server's identity.
header_remove("X-Powered-By");

// Some performance and caching adjustments - if not possible on the server side.
header("Connection: keep-alive");
header_remove("ETag");

?>