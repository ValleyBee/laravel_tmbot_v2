<?php

namespace App\Jobs;


use App\Enums\Users\Status;
use App\Enums\Users\Status as UsersStatus;
use App\Http\Controllers\Botusers as BotUsersController;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Botuser as BotUserModel;

class SendMailToAdmin implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?BotUserModel $botUserModel = null;
    protected ?BotUsersController $botUsersController = null;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->botUserModel == null) {
		 $this->botUserModel = app('botuser');
        }
        if ($this->botUsersController === null) {
            $this->botUsersController = app('botuserscontroller');
        }
        Log::info('handler Queue job SendMailToAdmin');
        Log::channel('stderr')->info("handler Queue job SendMailToAdmin");

        $user_status_result = $this->botUserModel->getCountUsersWithStatus(UsersStatus::NOT_AUTHORIZED);

        if ($user_status_result->count()) {
            Log::channel('stderr')->info("SendMail, we have new user");
            $this->botUsersController->sendMessageToUserTmbot(
                user_chat_id: 909149522, message: 'We have new user: '.$user_status_result->count(),
            );

        }

//        Storage::append('myapp.log', date('H:i:s') . "handler Queue job Botuser started");


    }
}
