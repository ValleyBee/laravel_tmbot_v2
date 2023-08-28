<?php

namespace App\Listeners;

use App\Events\MessageProcess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use stdClass;
use Telegram\Bot\Helpers;

class MessageHandler
{

    public string $botuser_id;
    public string $update_id;
    public int $message_id;
    public string $first_name;
    public string $last_name;
    public string $content;

    public function __construct(

        //        string $botuser_id,
//        string $update_id,
//        int    $message_id,
//        string $first_name,
//        string $last_name,
//        string $content,
    )
    {

//        $this->botuser_id = $botuser_id;
//        $this->update_id = $update_id;
//        $this->message_id = $message_id;
//        $this->first_name = $first_name;
//        $this->last_name = $last_name;
//        $this->content = $content;

    }

    /**
     * Handle the event.
     */
    public function handle(MessageProcess $event) : MessageHandler
    {
        $messageType = Helpers\Update::find($event->response)->messageType();
        $type = Helpers\Update::find($event->response)->type();
        Log::channel('stderr')->info('Message type:', [$type]);

        switch ($type) {
            case("message"):
                $arg = "message";
            case ("edited_message"):
                $arg = "message";
            case("callback_query"):
        }
/**

           $message = new stdClass();
            $message->botuser_id = $event->response[$arg]['from']['id'] ?? 0;
           $message->update_id = $event->response['update_id'] ?? 0;
           $message->message_id =$event->response[$arg]['message_id'] ?? 0;
           $message->first_name = $event->response[$arg]['from']['first_name'] ?? '';
           $message->last_name = $event->response[$arg]['from']['last_name'] ?? '';
           $message->content = $event->response[$arg]['text'] ?? '';

           return (object)$message;
*/



            $this->botuser_id = $event->response[$arg]['from']['id'] ?? 0;
            $this->update_id = $event->response['update_id'] ?? 0;
            $this->message_id =$event->response[$arg]['message_id'] ?? 0;
            $this->first_name = $event->response[$arg]['from']['first_name'] ?? '';
            $this->last_name = $event->response[$arg]['from']['last_name'] ?? '';
            $this->content = $event->response[$arg]['text'] ?? '';


//            $event->botuser_id = $event->response[$arg]['from']['id'] ?? 0;
//            $event->update_id = $event->response['update_id'] ?? 0;
//            $event->message_id =$event->response[$arg]['message_id'] ?? 0;
//            $event->first_name = $event->response[$arg]['from']['first_name'] ?? '';
//            $event->last_name = $event->response[$arg]['from']['last_name'] ?? '';
//            $event->content = $event->response[$arg]['text'] ?? '';


return $this;

    }
/**
$event->response->botuser_id = $event->response[$arg]['from']['id'] ?? 0;
$event->response->update_id = $event->response['update_id'] ?? 0;
$event->response->message_id = $responseFromTmbot[$arg]['message_id'] ?? 0;
$event->response->first_name = $responseFromTmbot[$arg]['from']['first_name'] ?? '';
$event->response->last_name = $responseFromTmbot[$arg]['from']['last_name'] ?? '';
$event->response->content = $responseFromTmbot[$arg]['text'] ?? '';
 */


}
