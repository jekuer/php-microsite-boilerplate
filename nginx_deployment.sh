#!/bin/bash
# This script can be used to setup the nginx site on deployment. Mind the paths below.
# A use case here would be Microsoft Azure WebApps at PHP v8.0+, where you need to use this as startup command (/home/site/wwwroot/nginx_deployment.sh) in order to get it work as expected (mind that this would always use the previous deployment; if you want to use the current one, you would need to navigate into the latest deployment folder, not wwwroot).
# Kudos go to https://github.com/schakko

echo "Replacing the default nginx configuration"
cp /home/site/wwwroot/nginx_conf/my.conf /etc/nginx/sites-available/default
 
echo "Reloading nginx to apply new configuration"
service nginx reload
