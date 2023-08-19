#! /bin/sh

cd /home/user
(crontab -u $(whoami) -r)
kill $(ps aux | grep '=schedule:run' | grep -v grep | awk '{print $2}')
sleep 10
# crontab  cd /var/www/html/tmbot && sudo php artisan schedule:run >> /dev/null 2>&1

kill $(ps aux | grep '=TmUpdates' | grep -v grep | awk '{print $2}')
kill $(ps aux | grep '=SendAnswerAiUsers' | grep -v grep | awk '{print $2}')
kill $(ps aux | grep '=model_free_one' | grep -v grep | awk '{print $2}')
kill $(ps aux | grep '=model_pay_one' | grep -v grep | awk '{print $2}')

cd /var/www/html/tmbot && php artisan queue:clear --queue=TmUpdates
cd /var/www/html/tmbot && php artisan queue:clear --queue=SendAnswerAiUsers
cd /var/www/html/tmbot && php artisan queue:clear --queue=model_free_one
cd /var/www/html/tmbot && php artisan queue:clear --queue=model_pay_one

cd /var/www/html/tmbot && php artisan cache:clear
cd /var/www/html/tmbot && php artisan conf:clear
cd /var/www/html/tmbot && php artisan view:clear
cd /var/www/html/tmbot && php artisan queue:clear
cd /var/www/html/tmbot && php artisan queue:flush
cd /var/www/html/tmbot && php artisan queue:restart
cd /var/www/html/tmbot &&php artisan queue:prune-failed
cd /var/www/html/tmbot && php artisan queue:prune-batches


