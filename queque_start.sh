#! /bin/sh
cd /var/www/html/tmbot &&
nohup php artisan queue:work --queue=TmUpdates --daemon  > /dev/null 2>&1 &
nohup php artisan queue:work --queue=SendAnswerAiUsers --daemon  > /dev/null 2>&1 &
nohup php artisan queue:work --queue=model_free_one --daemon  > /dev/null 2>&1 &
nohup php artisan queue:work --queue=model_pay_one --daemon  > /dev/null 2>&1 &
# crontab  cd /var/www/html/tmbot && sudo php artisan schedule:run >> /dev/null 2>&1
