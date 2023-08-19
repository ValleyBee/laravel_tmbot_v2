#! /bin/sh
cd /var/www/html/tmbot
echo "Start cleaning failed jobs"
echo "Start queue:work --queue=TmUpdates"
cd /var/www/html/tmbot && nohup php artisan queue:work --queue=TmUpdates --daemon  > /dev/null 2>&1 &
