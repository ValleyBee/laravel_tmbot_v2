<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Botuser as BotuserModel;
use App\Http\Controllers\Botusers as BotuserController;

use Telegram\Bot\BotManager;
use App\Models\Botmessages;
use App\Models\Aibot;
use App\Models\AiModelOne;
use App\Models\AiModelTwo;
use OpenAI\Client as OpenAIClientBot;

use Illuminate\Support\Facades\Process;



// use Telegram\Bot\Laravel\Facades\Telegram;
// use Telegram\Bot\Api as Telegram;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
//        $this->app->useStoragePath('/storage/logs/');

		// $this->app->singleton(Botuser::class, function ($app) {
		// 	echo "this is AppServiceProvider classsss";
		// 	return new Botuser(config('botuser'));
		// });

		// $this->app->singleton(Botuser::class);

		// $this->app->bind('botuser', BotuserModel::class);
		$this->app->singleton('botuser', BotuserModel::class);
		// $this->app->singleton('botuser', BotuserModel::class,  function ($app) {
		// 	$configuration = [
		// 		'test1' => 'test1_test1',
		// 		'test2' => '123456'
		// 	];
		// 	return $this->app->make(BotuserModel::class, $configuration);
		// });



		$this->app->singleton('botuserscontroller', BotuserController::class);

		// $this->app->singleton('message', Message::class);
		$this->app->singleton('botmessage', Botmessages::class);

		$this->app->singleton('telegram', BotManager::class);
		$this->app->singleton('aibot', Aibot::class);
		$this->app->singleton('aimodelone', AiModelOne::class);
		$this->app->singleton('aimodeltwo', AiModelTwo::class);

		// $this->app->singleton('aibotdata', AiBotData::class);
		$this->app->singleton('aiclientbot', OpenAIClientBot::class);
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
        $result = Process::quietly()->run('bash log_perm_change.sh');
		// DB::beforeExecuting(function ($query) {
		// 	echo ("<div class='text-black'> <em> $query </em></div>");
		// });
	}
}
