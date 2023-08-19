#! /bin/sh

cd /home/user
(crontab -u $(whoami) -r)
kill $(ps aux | grep '=schedule:run' | grep -v grep | awk '{print $2}')
sleep 1
# crontab  cd /var/www/html/tmbot && sudo php artisan schedule:run >> /dev/null 2>&1
cd /var/www/html/tmbot &&php artisan queue:prune-failed
cd /var/www/html/tmbot && php artisan queue:prune-batches
cd /var/www/html/tmbot && php artisan queue:work --queue=TmUpdates --stop-when-empty


