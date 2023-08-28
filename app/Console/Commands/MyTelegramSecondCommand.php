<?php

namespace App\Console\Commands;


use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Commands\Contracts\CommandContract;
use Telegram\Bot\Enums\Actions;


use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Keyboard\KeyboardButton;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardButton;

use Telegram\Bot\Objects\ResponseObject;

class MyTelegramSecondCommand extends Command
{
    protected string $description = 'Scond command, do somthing';
    protected string $name = 'second';

    /**
     * @throws TelegramSDKException
     * @throws TelegramCommandException
     */
    public function __construct()
    {
        echo "this is MyTelegramSecondClass";
        Log::channel('stderr')->info("this is MyTelegramSecondClass");

    }

    public function triggerCommand(string|CommandContract $command, array $params = []): void
    {
        parent::triggerCommand($command, $params); // TODO: Change the autogenerated stub
    }

    public function handle(ResponseObject $update)
    {
        # username from Update object to be used as fallback.
        Log::channel('stderr')->info("Hello this is MyTelegramSecondClass Welcome to our bot, Here are our available commands:");

        $keyboard = KeyboardButton::make()
            ->row([

                    ['text' => 'Test', 'callback_data' => 'data'],
                    ['text' => 'Btn 2', 'callback_data' => 'data_from_btn2'],
                ]
            );

//        $this->replyWithMessage(['text' => 'Start command', 'reply_markup' => $keyboard]);


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
