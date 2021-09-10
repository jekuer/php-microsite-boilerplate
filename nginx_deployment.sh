#!/bin/bash
# This script can be used to setup the nginx site on deployment.
# A use case here would be Microsoft Azure WebApps at PHP v8.0+, where you need to use this as startup command (/home/site/repository/nginx_deployment.sh) in order to get it work as expected.
# Kudos go to https://github.com/schakko

echo "Replacing the default nginx configuration"
cp /home/site/repository/deployment/nginx_conf/my.conf /etc/nginx/sites-available/default
 
echo "Reloading nginx to apply new configuration"
service nginx reload