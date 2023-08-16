<?php

namespace App\Http\Helpers;

use Illuminate\Support\Collection;

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


    public static function ResponseMessages(Collection $responseFromTmbot)
    {

        $arg = "message";

        # "EDITED MESSAGE";
        if (isset($responseFromTmbot['edited_message'])) {
            $arg = 'edited_message';
echo  "EDITED MESSAGE";
        }
        return new ResponseMessages(
            $responseFromTmbot[$arg]['from']['id'] ?? 0,
            $responseFromTmbot['update_id'] ?? 0,
            $responseFromTmbot[$arg]['message_id'] ?? 0,
            $responseFromTmbot[$arg]['from']['first_name'] ?? '',
            $responseFromTmbot[$arg]['from']['last_name'] ?? '',
            $responseFromTmbot[$arg]['text'] ?? ''

        );

    }


}
