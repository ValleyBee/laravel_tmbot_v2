php -S 0.0.0.0:8000 -t public
php start_test.php >/dev/null &
# Artisan 
php artisan make:controller Aibot --resource
php artisan vendor:publish --tag="telegram-config"
php artisan make:migration add_option_post --table="posts"
php artisan migrate  --path=/database/migrations/2023_05_10_110609_add_option_post.php
php artisan migrate:rollback  --path=/database/migrations/2023_05_08_091422_add_status_post.php 
php artisan make:model Post --migration
php artisan make:request Posts/Save
# SCHEDULE
php artisan schedule:work
php artisan queue:work --max-jobs=100
php artisan queue:work --max-jobs=1 --queue=model_free
# CRONTAB
cd /var/www/html/my-project && sudo php artisan schedule:run >> /dev/null 2>&1

# QUEUE
php artisan queue:clear
php artisan queue:flush
php artisan queue:restart
php artisan queue:prune-failed
artisan queue:prune-batches

# JOB
php artisan make:job SendQuestionAiDelay
nohup php artisan queue:work  --queue=model_free_one --daemon >> storage/logs/myapp.log &
nohup php artisan queue:work  --queue=TmUpdates --daemon > /dev/null 2>&1 &


composer require openai-php/client
composer require guzzlehttp/guzzle
composer require protonemedia/laravel-form-components

composer create-project laravel/laravel tmbot
composer create-project --prefer-dist botman/studio tmbot

# Clear Laravel Cache with PHP Programing

Import the Cache facade at the top of your PHP script.
# use Illuminate\Support\Facades\Cache;

# Use the `Cache::flush` method to clear the entire cache. This method removes all keys from the cache, regardless of the cache driver being used.
Cache::flush();

# Use the Cache::forget method to delete a specific key from the cache. This method takes a key as an argument and removes the corresponding key-value pair from the cache.
Cache::forget('key');

That’s it! The cache is now cleared, and all keys have been removed.

# MYSQL
mysql -u root -p -e "show open tables LIKE 'botmessages';"


 sudo chmod -R g+w tmbot
