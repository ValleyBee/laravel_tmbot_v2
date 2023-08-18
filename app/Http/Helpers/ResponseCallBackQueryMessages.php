<?php

namespace App\Http\Helpers;

use App\Enums\Messages\Status as MessageStatus;
use App\Models\Botuser as BotUserModel;
use Illuminate\Support\Collection;
use stdClass;
use Telegram\Bot\Objects\ResponseObject;

class ResponseCallBackQueryMessages
{


//   protected $guarded = [];

    public int $id;
    public int $user_id;
    public string $botuser_id;
    public string $update_id;
    public int $message_id;
    public string $first_name;
    public string $last_name;
    public string $content;

    protected function __construct(
        int    $id,
        string $botuser_id,
        string $update_id,
        int    $message_id,
        string $first_name,
        string $last_name,
        string $content,
    )
    {
        $this->id = $id;
        $this->botuser_id = $botuser_id;
        $this->update_id = $update_id;
        $this->message_id = $message_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->content = $content;
    }
    public static function ResponseCallBackQueryMessages(Collection $responseFromTmbot)
    {
        return new ResponseCallBackQueryMessages(
            id:$responseFromTmbot['callback_query']['id'] ?? 0,
            botuser_id: $responseFromTmbot['callback_query']['from']['id'] ?? 0,
            update_id: $responseFromTmbot['update_id'] ?? 0,
            message_id: $responseFromTmbot['callback_query']['message']['message_id'] ?? 0,
            first_name: $responseFromTmbot['callback_query']['from']['first_name'] ?? '',
            last_name: $responseFromTmbot['callback_query']['from']['last_name'] ?? '',
            content:$responseFromTmbot['callback_query']['data'] ?? '',

        );
    }
    public function handlerCallBackQueryMessages(int $user_id): void
    {
        $this->user_id = $user_id;
        $botMessageModel = app('botmessage');
        $botUserModel = app('botuser');
        $botUserModel->setUserRollModel($this->user_id, (int)$this->content);
        $messageIsExist = $botMessageModel->findIsMsgExistByMsg_id($this->message_id);
        if (!$messageIsExist) {
            $msg_pk_id = $botMessageModel->storeOnlyNewTmMesssages($this->user_id, $this);
            $botMessageModel->setStatusMessage($msg_pk_id, MessageStatus::MENU);
        }
    }

}
