<?php

namespace App\Jobs;

use App\Enums\Messages\Status;
use App\Enums\Messages\Status as MessageStatus;
use App\Http\Controllers\BotsMessages;
use App\Models\Aibot;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendAnswerAiUsers implements ShouldQueue
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
         Log::info('handler Queue job SendAnswerAiUsers started');
         for ($i=0 ; $i<=10; $i++) {
//             info('handler Queue job BotsMessage runner REPLY started');
             Storage::append('myapp.log', date('H:i:s') . "handler Queue job BotsMessage runner REPLY started");
             BotsMessages::runner(MessageStatus::REPLY);
//             info('handler Queue job BotsMessage runner NODELAY started');
             Storage::append('myapp.log', date('H:i:s') . "handler Queue job BotsMessage runner NODELAY started");
             BotsMessages::runner(MessageStatus::NODELAY);
//             info('handler Queue job BotsMessage runner DELAY started');
             Storage::append('myapp.log', date('H:i:s') . "handler Queue job BotsMessage runner DELAY started");
             BotsMessages::runner(MessageStatus::DELAY);
//             info('handler Queue job BotsMessage runner all job fineshed');
             Storage::append('myapp.log', date('H:i:s') . "handler Queue job BotsMessage runner all job fineshed");
             usleep(2 * 5000); # 2 * 1000 for two miliseconds:
         }
         Log::info('handler Queue job SendAnswerAiUsers fineshed');
    }
}
