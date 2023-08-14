<?php

namespace App\Console;

use App\Enums\Messages\Status;
use App\Enums\Messages\Status as MessageStatus;

use App\Http\Controllers\Botusers;
use App\Jobs\SendAnswerAiUsers;
use App\Jobs\SendQuestionNoDelay;
use App\Jobs\SendQuestionDelay;
use App\Jobs\TmUpdates;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\AiBotClientData;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    // protected ?Botusers $botuserscontroller = null;


    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {

//
        $schedule->call(function ()  {
           $r = new Botusers();
           $r->start();


        })->name('botusers')->withoutOverlapping();
//
//        $schedule->call(function ()  {
//
//            $r2 = new BotsMessages();
//            $r2->start();
//
//        })->name('controller_one')->everyTwoSeconds();
//
        $schedule->call(function () {
//            Aibot::runner(MessageStatus::DELAY);
//            info('handler Queue SendQuestionDelay');
            Storage::append('myapp.log', date('H:i:s') . "handler Queue SendQuestionDelay");

            SendQuestionDelay::dispatch()->onQueue("model_free_one");
//            \Illuminate\Support\Facades\Bus::batch([
//                new SendQuestionAi,
//            ])->name("model_pay")->onQueue("model_pay")->allowFailures()
//                ->dispatch();
        })->name('controller_aibot_delay')->everyThirtySeconds();

        $schedule->call(function () {
//            Aibot::runner(MessageStatus::NODELAY);
//            info('handler Queue SendQuestionNoDelay');
            Storage::append('myapp.log', date('H:i:s') . "handler Queue SendQuestionNoDelay");
            SendQuestionNoDelay::dispatch()->onQueue("model_pay_one");
//            \Illuminate\Support\Facades\Bus::batch([
//                new SendQuestionAiDelay(),
//            ])->name("model_pay2")->onQueue("model_pay2")->allowFailures()
//                ->dispatch();
        })->name('controller_aibot_nodelay')->everyTwoSeconds();


        $schedule->call(function () {
//            info('handler Queue tm_updates');
            Storage::append('myapp.log', date('H:i:s') . "handler Queue tm_updates");
            /** only ones to be run. there is a loop inside method of updates */
            TmUpdates::dispatch()->onQueue("TmUpdates");

        })->name('controller_botusers')->withoutOverlapping()->everyTwoSeconds();

        /** only ones to be run. there is a for-loop call runner within handle()  */
        $schedule->call(function () {
//            info('handler Queue job Botmessages');
            Storage::append('myapp.log', date('H:i:s') . "handler Queue job Botmessages");
            SendAnswerAiUsers::dispatch()->onQueue("SendAnswerAiUsers");
        })->name('controller_botmessages')->withoutOverlapping()->everyTwoSeconds();


        /**
         * $schedule->call(function () {
         *
         * \Illuminate\Support\Facades\Bus::batch([
         * new SendQuestionAiDelay,
         * ])->name("model_free")->onQueue("model_free")->allowFailures()
         * ->dispatch();
         *
         * })->name('controller_model_free')->withoutOverlapping()->everyThirtySeconds();
         *
         *
         * $schedule->call(function () {
         *
         * new SendQuestionAiDelay();
         * echo "schedule SendQuestionAiDelay ";
         * })->name('controller_model_free')->everyThirtySeconds();
         */




//         $schedule->call(new Botusers())->name('controller_one')->everyTwoSeconds();
//         $schedule->call(new BotsMessages())->name('controller_two')->everyTwoSeconds();

        // if ($this->botuserscontroller == null) {
        // 	echo "<font color='blue'>" . "NEW INSTANCE Botusercontroller in scedule " . "</font>";
        // 	$this->botuserscontroller = app('botuserscontroller');
        // }
        // $schedule->command('inspire')->everyTwoSeconds();
//		 $schedule->call(new Botusers())->name('controller_one')->everyTwoSeconds();

        /*I found the following works quite well for my use case:

        Copy
        $schedule->command(FooBarCommand::class)->everyMinute()->thenWithOutput(fn (Stringable $output) => print($output));*/

        $url_1 = "http://localhost:8000/tm";
        $url_2 = "http://localhost:8000/msg";

//		 $schedule->call('App\Http\Controllers\Botusers@runner')
//             ->name('controller_one')
//             ->everyTwoSeconds();->everyThirtySeconds();


//
//        $schedule->exec('everyminute')
//            ->name('controller_two')
//            ->everyTwoSeconds();

        /*

                $schedule->call(function () use ($url_1) {
                    //ignore_user_abort(true);
                    set_time_limit(0);
                    //$data = file_get_contents('start.txt');
                    //$d = 0;
                    // Add 1 to $data
                    $curl = curl_init($url_1);
                    curl_setopt($curl, CURLOPT_URL, $url_1);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $resp = curl_exec($curl);
                    curl_close($curl);
                })->name('controller_one')->everyTwoSeconds();
                */
        /*
            $schedule->call(function () use ($url_2) {
                    //ignore_user_abort(true);
                    set_time_limit(0);
                    //$data = file_get_contents('start.txt');
                    //$d = 0;
                    // Add 1 to $data
                    $curl = curl_init($url_2);
                    curl_setopt($curl, CURLOPT_URL, $url_2);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $resp = curl_exec($curl);
                    curl_close($curl);
                })->name('controller_two')->everyThirtySeconds();
        */
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
