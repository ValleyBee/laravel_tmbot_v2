<?php

namespace App\Jobs;

use App\Enums\Messages\Status as MessageStatus;
use App\Models\Aibot;
use App\Models\AiBotClientData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Log;

class SendQuestionDelay implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
//        $this->handle();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
//for ($i=0 ; $i<=10; $i++) {
        Log::info('handler Queue job SendQuestionDelay started');
//        $this->job_two();
//        AiBotClientData::runner_free();
    Aibot::runner(MessageStatus::DELAY,0);
//        Aibot::dispatch()->delay(now()->addMinutes(1));;
//    echo ('handler Queue job DELAY');
//        info('handler Queue job DELAY finished');
//}
    }

    public function job_two()
    {
        $i = 1;
        ${'a' . $i} = new AiBotClientData('free');
        ${'a' . $i}->model();
//        ${'b' . $i} = new AiBotClientData('free');
//        ${'b' . $i}->model();
//        echo "Variable name is " . ${'a' . $i}, "\n";
//        echo "My name is ", get_class(${'a' . $i}), "\n";
//        print_r("memory_get_usage = " . memory_get_usage());
    }
}
