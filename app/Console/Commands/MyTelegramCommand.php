<?php

namespace App\Console\Commands;


use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Enums\Actions;


use Telegram\Bot\Objects\Keyboard\KeyboardButton;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardButton;

use Telegram\Bot\Objects\ResponseObject;

class MyTelegramCommand extends Command
{
    protected string $description = 'First command, do somthing';
    protected string $name = 'first';

    public function __construct()
    {
        echo "this is MytelegramClass";
        Log::channel('stderr')->info("this is MytelegramClass");

    }

    public function handle(ResponseObject $update)
    {
        # username from Update object to be used as fallback.
        Log::channel('stderr')->info("Hello  Welcome to our bot, Here are our available commands:");

        $fallbackUsername = $this->setUpdate($update);
        var_dump($fallbackUsername->getName());

        $keyboard = KeyboardButton::make()
            ->row([

                    ['text' => 'Test', 'callback_data' => 'data'],
                    ['text' => 'Btn 2', 'callback_data' => 'data_from_btn2'],
                ]
            );

//        $this->replyWithMessage(['text' => 'Start command', 'reply_markup' => $keyboard]);
$result = $this->bot->getClient()->getConfig();

//                var_dump($result);


        # Get the username argument if the user provides,
        # (optional) fallback to username from Update object as the default.
//        $username = $this->argument(
//            'username',
//            $fallbackUsername
//        );
//
//        $this->replyWithMessage([
//            'text' => "Hello {$username}! Welcome to our bot, Here are our available commands:"
//        ]);


    }
}
