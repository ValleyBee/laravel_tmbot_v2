<?php

namespace App\Http\Helpers;

use Illuminate\Support\Collection;
use Telegram\Bot\Objects\ResponseObject;

class ResponseCallBackQueryMessages
{


//   protected $guarded = [];

    public int $id;
    public string $botuser_id;
    public string $update_id;
    public int $message_id;
    public string $first_name;
    public string $last_name;
    public string $content;

    protected function __construct(
        int $id,
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
            $responseFromTmbot['callback_query']['id'] ?? 0,
            $responseFromTmbot['callback_query']['from']['id'] ?? 0,
            $responseFromTmbot['update_id'] ?? 0,
            $responseFromTmbot['callback_query']['message']['message_id'] ?? 0,
            $responseFromTmbot['callback_query']['from']['first_name'] ?? '',
            $responseFromTmbot['callback_query']['from']['last_name'] ?? '',
            $responseFromTmbot['callback_query']['data'] ?? '',

        );

    }


}
