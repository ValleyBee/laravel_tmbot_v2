#! /bin/sh
cd /var/www/html/tmbot
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
