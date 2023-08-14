<?php

namespace App\Jobs;

use App\Enums\Messages\Status as MessageStatus;
use App\Models\AiBotClientData;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Aibot;
use Illuminate\Support\Facades\Log;

class SendQuestionNoDelay implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

//        info('handler Queue job NODELAY started');
        Log::info('handler Queue job SendQuestionNoDelay started');
//for ($i=0 ; $i<=5; $i++) {
//        AiBotClientData::runner_pay();
        Aibot::runner(MessageStatus::NODELAY,5);



//        ${'b' . $i} = new AiBotClientData('pay_two');
//        ${'b' . $i}->model();
//        info('handler Queue job NODELAY finished');
//    usleep( 2 *2000);
//    }
    }

public function job_one(){
        $i=1;
    ${'a' . $i} = new AiBot(date('H:i:s'));
}

}
