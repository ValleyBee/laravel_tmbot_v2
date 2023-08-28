<?php

namespace App\Http\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Helpers as TmBotHelpers;

class ResponseMessages
{


//   protected $guarded = [];


    public string $botuser_id;
    public string $update_id;
    public int $message_id;
    public string $first_name;
    public string $last_name;
    public string $content;

    protected function __construct(
        string $botuser_id,
        string $update_id,
        int    $message_id,
        string $first_name,
        string $last_name,
        string $content,
    )
    {

        $this->botuser_id = $botuser_id;
        $this->update_id = $update_id;
        $this->message_id = $message_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->content = $content;

    }


    public static function ResponseMessages(ResponseObject $responseFromTmbot)
    {

        $messageType = TmBotHelpers\Update::find($responseFromTmbot)->messageType();
        $type = TmBotHelpers\Update::find($responseFromTmbot)->type();
        Log::channel('stderr')->info('Message type:', [$type]);

        switch ($type) {
            case("message"):
                $arg = "message";
            case ("edited_message"):
                $arg = "message";
            case("callback_query"):
        }


        return new ResponseMessages(
            botuser_id: $responseFromTmbot[$arg]['from']['id'] ?? 0,
            update_id: $responseFromTmbot['update_id'] ?? 0,
            message_id: $responseFromTmbot[$arg]['message_id'] ?? 0,
            first_name: $responseFromTmbot[$arg]['from']['first_name'] ?? '',
            last_name: $responseFromTmbot[$arg]['from']['last_name'] ?? '',
            content: $responseFromTmbot[$arg]['text'] ?? ''

        );
    }

}
