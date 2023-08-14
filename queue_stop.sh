#! /bin/sh

cd /home/user
(crontab -u $(whoami) -r)
kill $(ps aux | grep '=schedule:run' | grep -v grep | awk '{print $2}')
sleep 1
# crontab  cd /var/www/html/tmbot && sudo php artisan schedule:run >> /dev/null 2>&1

kill $(ps aux | grep '=TmUpdates' | grep -v grep | awk '{print $2}')
kill $(ps aux | grep '=SendAnswerAiUsers' | grep -v grep | awk '{print $2}')
kill $(ps aux | grep '=model_free_one' | grep -v grep | awk '{print $2}')
kill $(ps aux | grep '=model_pay_one' | grep -v grep | awk '{print $2}')


php artisan queue:clear --queue=TmUpdates
php artisan queue:clear --queue=SendAnswerAiUsers
php artisan queue:clear --queue=model_free_one
php artisan queue:clear --queue=model_pay_one


php artisan cache:clear
php artisan conf:clear
php artisan view:clear
php artisan queue:clear
php artisan queue:flush
php artisan queue:restart
php artisan queue:prune-failed
php artisan queue:prune-batches


