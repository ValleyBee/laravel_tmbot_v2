<?php

namespace App\Listeners;

use App\Events\UserProcess;
use App\Models\Botuser as BotUserModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\Users\Status as UserStatus;
use stdClass;

class UsersHandler
{
    protected ?BotUserModel $botUserModel = null;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserProcess $event): stdClass|null
    {
        if ($this->botUserModel == null) {
            $this->botUserModel = app('botuser');
        }
//        dd($event->response);
        return $this->botUserModel->findByBotuser_id($event->response->botuser_id);

    }
}
