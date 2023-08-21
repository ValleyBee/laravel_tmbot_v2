#! /bin/sh
cd /var/www/html/tmbot
echo "Start cleaning queue:work and cache and conf"

cd /var/www/html/tmbot && php artisan queue:clear --queue=TmUpdates
cd /var/www/html/tmbot && php artisan queue:clear --queue=SendAnswerAiUsers
cd /var/www/html/tmbot && php artisan queue:clear --queue=model_free_one
cd /var/www/html/tmbot && php artisan queue:clear --queue=model_pay_one
cd /var/www/html/tmbot && php artisan queue:clear --queue=SendMailToAdmin


cd /var/www/html/tmbot && php artisan cache:clear
cd /var/www/html/tmbot && php artisan conf:clear
cd /var/www/html/tmbot && php artisan view:clear
cd /var/www/html/tmbot && php artisan queue:clear
cd /var/www/html/tmbot && php artisan queue:flush
cd /var/www/html/tmbot && php artisan queue:restart
cd /var/www/html/tmbot && php artisan queue:prune-failed
cd /var/www/html/tmbot && php artisan queue:prune-batches

sleep 1
echo "Start queue:work --queue=TmUpdates"
cd /var/www/html/tmbot && nohup php artisan queue:work --queue=TmUpdates --daemon  > /dev/null 2>&1 &
sleep 1
echo "Start queue:work --queue=SendAnswerAiUsers"
 cd /var/www/html/tmbot && nohup php artisan queue:work --queue=SendAnswerAiUsers --daemon  > /dev/null 2>&1 &
sleep 1
echo "Start queue:work --queue=model_free_one"
 cd /var/www/html/tmbot && nohup php artisan queue:work --queue=model_free_one --daemon  > /dev/null 2>&1 &
sleep 1
echo "Start queue:work --queue==model_pay_one"
 cd /var/www/html/tmbot && nohup php artisan queue:work --queue=model_pay_one --daemon  > /dev/null 2>&1 &
sleep 1
echo "Start queue:work --queue==SendMailToAdmin"
 cd /var/www/html/tmbot && nohup php artisan queue:work --queue=SendMailToAdmin --daemon  > /dev/null 2>&1 &



# crontab  cd /var/www/html/tmbot &&  php artisan schedule:run >> /dev/null 2>&1


#kill $(ps aux | grep '=TmUpdates' | grep -v grep | awk '{print $2}')

sleep 1
cd /home/user
line="* * * * * cd /var/www/html/tmbot && php artisan schedule:run >> /dev/null 2>&1"
(crontab -u $(whoami) -l; echo "$line" ) | crontab -u $(whoami) -
