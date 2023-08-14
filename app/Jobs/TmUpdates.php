<?php

namespace App\Jobs;

use App\Enums\Messages\Status;
use App\Enums\Messages\Status as MessageStatus;
use App\Models\AiBotClientData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\Botusers;
use App\Http\Controllers\BotsMessages;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class TmUpdates implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {



//        echo "constructor Queue job";
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('handler Queue job TmUpdates started');
//        Storage::append('myapp.log', date('H:i:s') . "handler Queue job Botuser started");
        Botusers::runner();
//        Storage::append('myapp.log', date('H:i:s') . "handler Queue job Botuser finished");
//        Log::info('handler Queue job TmUpdates finished');
//        \Illuminate\Support\Facades\Bus::batch([
//            Botusers::runner(),
//        ])->name("starter")->onQueue("starter")->allowFailures()->dispatch();




        //        for ($i=0 ; $i<=100; $i++) {
//            Botusers::runner();
//            echo ('handler job Botuser runner '.$i);
//            usleep( 2 * 20000 );
//        }

      /**
        BotsMessages::runner(MessageStatus::NODELAY);
        BotsMessages::runner(MessageStatus::DELAY);
        BotsMessages::runner(MessageStatus::REPLY);

*/




//        ${'b' . $i} = new AiBotClientData('pay_two');
//        ${'b' . $i}->model();
//        logger('handler Queue job one finished');


//        for ($x = 1; $x <= 10; $x++) {
//            sleep(2);

        // do calculation
//        }
//        echo "handler Queue job two started\n";
//        $this->job_two();
//        echo "handler Queue job two finished\n";
    }

    public function job_one()
    {
        $i = 1;
//        while (!file_exists('../storage/logs/stop.txt')) {

//if (file_exists('../storage/logs/stop.txt')) {


        ${'a' . $i} = new AiBotClientData('pay');
        ${'a' . $i}->model();
        ${'b' . $i} = new AiBotClientData('pay_two');
        ${'b' . $i}->model();
//        echo "Variable name is " . ${'a' . $i}, "\n";
//        echo "My name is ", get_class(${'a' . $i}), "\n";
//        print_r("memory_get_usage = " . memory_get_usage());

//        $r = new Botusers();
//        $r->runner();
        /*
        set_time_limit(0);
        //$data = file_get_contents('start.txt');
        //$d = 0;
        // Add 1 to $data
        $url = "http://localhost/tm";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($curl);
        file_put_contents('../storage/logs/start_tm.log', $resp, FILE_APPEND | LOCK_EX);
//        file_put_contents($_SERVER['DOCUMENT_ROOT'].'storage/logs/start_tm.log', $resp, FILE_APPEND | LOCK_EX);

        curl_close($curl);
        */
    }

    public function job_two()
    {
        $r2 = new BotsMessages();
        $r2->start();

        /*

        set_time_limit(0);
        //$data = file_get_contents('start.txt');
        //$d = 0;
        // Add 1 to $data
        $url = "http://localhost/msg";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($curl);
        file_put_contents('../storage/logs/start_msg.log', $resp, FILE_APPEND | LOCK_EX);
//        file_put_contents($_SERVER['DOCUMENT_ROOT'].'storage/logs/start_tm.log', $resp, FILE_APPEND | LOCK_EX);

        curl_close($curl);
*/
    }


}
