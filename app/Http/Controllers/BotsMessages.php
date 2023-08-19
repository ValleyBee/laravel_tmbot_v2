<?php

namespace App\Http\Controllers;

use App\Enums\Messages\Status;
use Illuminate\Http\Request;

// use Telegram\Bot\Laravel\Facades\Telegram;
// use Telegram\Bot\Exceptions\TelegramResponseException;
use App\Models\Aibot;
use App\Models\Botmessages as BotMessageModel;
use App\Models\Botuser as BotUserModel;

// use App\Models\Message as Messages;
use App\Http\Controllers\Botusers as BotUsersController;
use App\Enums\Messages\Status as MessageStatus;
use App\Enums\Users\Status as UsersStatus;
use App\Enums\Users\UsersMenu;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use stdClass;

// use Illuminate\Support\Str;


class BotsMessages extends Controller
{
    protected ?BotMessageModel $botMessageModel = null;
    protected ?BotUserModel $botUserModel = null;
    protected ?Aibot $aiBot = null;
    protected ?BotUsersController $botUsersController = null;
    protected ?stdClass $stdClassMsg = null;
    protected ?stdClass $stdClassUser = null;


    protected bool $haveMassage = true;

    public int $i;
    protected $responseFields =
        // array(
        // 	'message' =>
        array(
            'message_id' => null,
            'update_id' => null,
            'botuser_id' => null,
            'first_name' => null,
            'last_name' => null,
            'content' => null,
            'status' => 0
        );

    protected function stop()
    {
        exit();
    }

//    public function __construct()
//    {
//
//    }
//
//    public function __invoke()
//    {
////      $this->start();
//    }

    public static function runner(MessageStatus $account)
    {

//        Log::channel('stderr')->info("botsmessages runner started");

        $instanceName = new BotsMessages();
        $instanceName->botMessageModel = new BotMessageModel();

        //        $stdClassMsg = new stdClass();
        $instanceName->stdClassMsg =
            $instanceName->botMessageModel
                ->getLastMsgWithStatusSetBusy($instanceName->botMessageModel, $account);


        if ($instanceName->stdClassMsg) {
            $instanceName->start($instanceName);
        }


//        echo date("d/m/Y H:i:s") . " " . "there are no unsent messages, result is null \n";
//        Log::info('botsmessages,there are no unsent messages, result is null');
//        Storage::append('botsmessages.log', date('H:i:s') . "there are no unsent messages, result is null");
//        Log::channel('stderr')->info("botsmessages,there are no unsent messages, result is null");
//        Log::channel('stderr')->info("botsmessages runner finished");
    }


    public function test()
    {
        if ($this->aiBot === null) {
            $this->aiBot = app('aibot');
        }
        Aibot::runner(MessageStatus::NODELAY);
    }

    /*

*/
    public function index()
    {
        echo "this is index";
    }

    public function allMessages()
    {
        echo "this is allMessages";
        if ($this->botMessageModel === null) {
            $this->botMessageModel = app('botmessage');
        }

        $this->botMessageModel->allMessages();
    }


    public function start(BotsMessages $instanceName)

    {

//        Storage::append('myapp.log', date('H:i:s') . "botmessages started");
        Log::info("botmessages method start() started ");
        Log::channel('stderr')->alert("botmessages method START");
        $i = 1;
//        for ($i=0; $i<=10000; $i++) {

        if ($this->aiBot === null) {
            $this->aiBot = app('aibot');
        }

//        if ($this->botMessageModel === null) {
//            $this->botMessageModel = app('botmessage');
//        }

        if ($this->botUserModel == null) {

            $this->botUserModel = app('botuser');
//                 $this->botUserModel = resolve(BotUserModel::class);
        }

        if ($this->botUsersController === null) {
            $this->botUsersController = app('botuserscontroller');
        }

//            if ($this->stdClassMsg == null) {
//                $this->stdClassMsg = new stdClass;
//            }
//
//            if ($this->stdClassUser == null) {
//                $this->stdClassUser = new stdClass;
//            }

//
//		(array)$lastMessage = [
//			'lastMessage' => [
//				'message_id' => null,
//				'update_id' => 0,
//				'id' => null,
//				'first_name' => null,
//				'last_name' => null,
//				'text' => null,
//				'status' => 0
//
//			]
//		];


        //$aibot = new Aibot();


        //dd($a_id);
        /*
        Telegram::bot('myfirstbot')->sendMessage([
            'chat_id' => '909149522',
            //'reply_to_message_id' => 123,
            'text' => 'Send message to Vаlentyn',
            'allow_sending_without_reply' => true
        ]);
*/


        // GET ALL MESSAGES
        /*
(array)$userLastMessage:12 [▼ // app/Http/Controllers/BotsMessages.php:106
  "id" => 1
  "created_at" => "2023-05-19T14:23:40.000000Z"
  "updated_at" => "2023-05-19T14:23:40.000000Z"
  "message_id" => 822xxcv
  "update_id" => "687831854"
  "first_name" => "Vаlentyn"
  "last_name" => "B"
  "content" => "о"
  "reply_from_ai" => null
  "status" => 0
  "user_id" => 6
  "botuser_id" => "909149522"
*/


        // (string)$getLastReplyById = '';
        (array)$validateUserMessageAiRules = [];
        (array)$answerFrom = [];
        (object)$replyToSendTmbot = null;

        //------------- I -------------------


//        dd($this->stdClassMsg);

        // (int) $secs = 30;
        // $photo =	$this->botUsersController->photoToUserTmbot([], []);

        /*$this->stdclass
{#1279 ▼ // app/Http/Controllers/BotsMessages.php:155
  +"id": 115
  +"created_at": "2023-07-09T17:22:45.000000Z"
  +"updated_at": "2023-07-09T18:37:40.000000Z"
  +"message_id": 1048
  +"update_id": "687831927"
  +"first_name": "Vаlentyn"
  +"last_name": "B"
  +"content": "dfu"
  +"reply_from_ai": null
  +"status_msg": 0
  +"user_id": 6
  +"botuser_id": "909149522"
}
*/


//        while (!file_exists('../storage/logs/stop.txt')) {
//            $this->haveMassage = true;
//
//        Storage::append('method_start', date('H:i:s') . "START" . $i);
//        $this->stdClassMsg = new stdClass();
//        $this->botMessageModel = new BotMessageModel();
//
//        $this->stdClassMsg =
//            $this->botMessageModel->getLastMsgIdWithStatusNull() ??
//            $this->botMessageModel->getLastMsgIdWithStatusDelay();


//        if ($this->stdClassMsg == null) {
//            $this->stdClassMsg = $this->botMessageModel->getLastMsgIdWithStatusDelay();

//            echo  date("d/m/Y H:i:s"). " ". "there are no unsent messages, result is null\n";
//			ob_start();

//          }
//            $this->haveMassage = false;
//            exit();

//        } # END IF NULL MESSAGES


        // echo "result get last message " . $this->stdclass->content;
//        if ($this->haveMassage) {
//        Storage::append('method_start', date('H:i:s') . "there is unsent messages, " . $i);
//        Log::info("there is unsent messages");
        $instanceName->stdClassUser = new stdClass();
        $instanceName->stdClassUser =
            $instanceName->botUserModel->getUser($this->stdClassMsg->user_id);
//                ${'class_aitbot' . $this->stdClassUser->botuser_id} = new Aibot();

        // echo $getLastReplyById;
        // dd($this->stdClassUser->lang);

        // return null or array with valuation category
        /* array:2 [▼ // app/Http/Controllers/BotsMessages.php:145
  "category" => "violence"
  "warningMessage" => "Sorry,but your last message valuates the rules in category of : "
] */


        // -----------------------III VALIDATION----------------
        // (bool)$validateUserMessageIsShort =
        // 	$this->aiBot->validateUserMessageIsShort($this->stdclass->content);


        if (Aibot::validateUserMessageLength($instanceName->stdClassMsg->content)) {
            $this->botMessageModel->setStatusMessage($instanceName->stdClassMsg->id, MessageStatus::REJECT);
            $instanceName->stdClassMsg->status_msg = MessageStatus::REJECT->value;
            Log::notice("Message REJECT by -> validateUserMessageLength");
            // $answerFrom = $this->aiBot->prepareAnswerMsgWithValuation($validateUserMessageIsShort);

            (string)$msg_to_user = config()->get('botsmanagerconf.' . UsersMenu::cases()[$instanceName->stdClassUser->lang]->name . '.ERROR.msg_validate')
                ?? "\xE2\x9A\xA0A message must be from 8 to 128 symbols.";
            $this->botUsersController->sendMessageToUserTmbot(
                $instanceName->stdClassMsg->botuser_id,
                $msg_to_user,
                $instanceName->stdClassMsg->message_id,
                null
            );



        }
        //-------------- II ---USER'S LAST REPLY FORM AI-------------


//                 dd($this->stdClassMsg);
        // (array)$validateUserMessageAiRules = $this->aiBot->validateUserMessageAiRules($this->stdclass->content);

        // ---------------------------IV -----------------

        /**
         * if ($validateUserMessageAiRules) {
         * $this->botMessageModel->setStatusMessage($instanceName->stdclass->id, MessageStatus::VIOLATION);
         * $answerFrom = $this->aiBot->prepareAnswerMsgWithValuation($validateUserMessageAiRules);
         * $replayToUserTmbot = $this->botUsersController->sendAnswerToUserTmbot($instanceName->stdClassMsg, $answerFrom);
         * exit();
         * }
         */

        /*
    Final event when passed all validation rules
    ------------------------V ---------------
    Get user's all data except token
        */
        // $resultStatus = $this->botUserModel->getUserStatus($this->stdclass->user_id);
        // $resultModelType = $this->botUserModel->getUserModelType($this->stdclass->user_id);

        // dd($resultStatus->name);


        switch (UsersStatus::cases()[$instanceName->stdClassUser->status_usr]->name) {
            case ("NEW_USER"):
//                echo date("d/m/Y H:i:s") . " " . "STATUS, NEW USER ";
//                Log::info("NEW USER ADDED by -> switch UsersStatus::cases");
                // $this->botUserModel->changeUserStatus($userFoundId, UsersStatus::NOT_AUTHORIZED);
                // self::sendMessageToUserTmbot($this->stdclass, $msg1 . $msg3 . $msg2);
                break;
            /*
                        case ("NOT_AUTHORIZED"):
                            echo date("d/m/Y H:i:s") . " " . "STATUS, NOT_AUTHORIZED USER ";
                          break;

                        case ("OUT_OF_LIMIT"):
            //                echo date("d/m/Y H:i:s") . " " . "STATUS, OUT_OF_LIMIT";

                            /* $msg_to_user = config()->get('botsmanagerconf.' . UsersMenu::cases()[$this->stdClassUser->lang]->name . '.INFO.msg_sent');

                            $this->botUsersController
                                ->sendMessageToUserTmbot(
                                    $this->stdClassMsg->botuser_id,
                                    $msg_to_user,
                                    null,
                                    null
                                );
                            break;
            */
            case ("NOT_AUTHORIZED"):

                break;
            case ("AUTHORIZED"):
            case ("OUT_OF_LIMIT"):

//                echo date("d/m/Y H:i:s") . " " . "STATUS, USER IS AUTHORIZED OR OUT_OF_LIMIT";
//                Log::info("BotsMessages,STATUS, USER IS AUTHORIZED OR OUT_OF_LIMIT by -> switch UsersStatus::cases");
//            Storage::append('myapp.log', date('H:i:s') . "STATUS, USER IS AUTHORIZED OR OUT_OF_LIMIT");
                // print_r($this->stdClassUser);


//                            $model = ${'class_aitbot' . $this->stdClassUser->botuser_id}->getModelOne();

//                dd($instanceName->stdClassMsg);
//
//                                ${'class_aitbot' . $this->stdClassUser->botuser_id}->
//                                clientAiApi(
//                                    $model,
//                                    $this->stdClassMsg,
//                                    $this->stdClassUser
//                                );

# GET ANSWER FOR TM-BOT


//                        $answerFrom['choices'][0]['message']['content'] = $replayToUserTmbot->reply_from_ai;


//                echo date("d/m/Y H:i:s") . "answer: " . "\n";
//                Storage::append('method_start', date('H:i:s') . "ANSWER" . $i);

//                            print_r(${'class_aitbot' . $this->stdClassUser->botuser_id}['usage']);
//                echo "\n";
//                print_r("after use classes OpenAi and Telegram memory_usage = " . memory_get_usage());
                break;
            case ("VIOLATION"):
                Log::info("BotsMessages,STATUS, USER VIOLATION by -> switch UsersStatus::cases");
//                echo date("d/m/Y H:i:s") . " " . "STATUS, USER IS VIOLATION";
                break;

            default:
                Log::alert("BotsMessages,something went wrong botmessages by -> switch UsersStatus::cases");
//                echo date("d/m/Y H:i:s") . " " . "something went wrong switch botmessages";
        }

        switch (MessageStatus::cases()[$instanceName->stdClassMsg->status_msg]->name) {
            case ("DELAY"):
            case ("NODELAY"):


                $instanceName->stdClassMsg->reply_from_ai = $this->botMessageModel->getLastReplyById($instanceName->stdClassMsg->user_id);
                /** cut reply to 128 characters */
                $instanceName->stdClassMsg->reply_from_ai = mb_substr($instanceName->stdClassMsg->reply_from_ai, 0, 128,'UTF-8');

                $this->aiBot->storeQuestionAi($instanceName->stdClassMsg);
                Log::info("BotsMessages,Message status delay and nodelay add in database, by -> storeQuestionAi");
                (string)$msg_to_user = "\u{2611}ID:" . $instanceName->stdClassMsg->message_id . " " .
                config()->get('botsmanagerconf.' . UsersMenu::cases()[$instanceName->stdClassUser->lang]->name . '.INFO.msg_accept')
                    ?? "\xE2\x9A\xA0Something went wrong,try again in a while...";
                $this->botUsersController
                    ->sendMessageToUserTmbot(
                        $instanceName->stdClassMsg->botuser_id,
                        $msg_to_user,
                        null,
                        null
                    );
                Log::info("BotsMessages,Message INFO.msg_accept sent to tm users, by -> sendMessageToUserTmbot");

                break;
            case ("REPLY"):
//                    $replyToSendTmbot = $this->botMessageModel->getLastMsgWithStatusReplySetDone($this->botMessageModel);
                if ($instanceName->stdClassMsg) {
                    $feedbackMessage = $this->botUsersController->sendAnswerToUserTmbot($instanceName->stdClassMsg);
                    Log::info("BotsMessages,Send answer to tm users, by -> sendAnswerToUserTmbot");

                    if ($feedbackMessage) {
                        $this->botMessageModel->setStatusMessage($instanceName->stdClassMsg->id, MessageStatus::DONE);
                        Log::info("BotsMessages,set status message DONE, by >setStatusMessage");
                    } else {
                        Log::alert("BotsMessages,rollback message status to REPLAY cause it was not send, by >sendAnswerToUserTmbot");
                        $this->botMessageModel->setStatusMessage($instanceName->stdClassMsg->id, MessageStatus::REPLY);
                    }


//                    (int)$countSymbols = mb_strlen($instanceName->stdClassMsg->content); // old way
                    (int)$countSymbols = 1;
                    $this->botUserModel->setUserLimit($instanceName->stdClassUser->id, $countSymbols);

//                    $this->botMessageModel->setMsgDoneWithReplay($instanceName->stdClassMsg->id, $answerFrom);
                    echo date("d/m/Y H:i:s") . "answer from ai: " . $instanceName->stdClassMsg->reply_from_ai . "\n";
                    echo date("d/m/Y H:i:s") . "botuser_id: " . $instanceName->stdClassMsg->botuser_id . "\n";
                    echo date("d/m/Y H:i:s") . "message_id: " . $instanceName->stdClassMsg->message_id . "\n";

//                    Storage::append('BotsMessages_method_start', date('H:i:s') . "send answer to tm bot" . $i);

                }
                break;
            default:
//                echo "event when message has not been replayied and message status (BUSY) remains";
                Log::alert("BotsMessages,message has not been replayied and message status (BUSY) remains, by -> MessageStatus::cases");
//                Storage::append('method_start', date('H:i:s') . "END" . $i);
        }


        /************** IF REPLAY SUCCESS ************/


//        } # END IF ELSE VALIDATION

//        } # IF HAVE  MESSAGES
//        $i++;
//                sleep(2);

//        exit();
//        }
//        echo "END START";
//        Storage::append('myapp.log', date('H:i:s') . "botmessages started");
        Log::info("botmessages method start() finished");
        Log::notice(print_r("memory_usage_Botmessage = " . memory_get_usage()));
        Log::channel('stderr')->alert("botmessages method FINISH");


    } // END START

    /*
array:6 [▼ // app/Http/Controllers/BotsMessages.php:144
"id" => "chatcmpl-7SWU2OerfJ50POsGlrQjlWgRsuq2d"
"object" => "chat.completion"
"created" => 1687032406
"model" => "gpt-3.5-turbo-16k-0613"
"choices" => array:1 [▼
0 => array:3 [▼
  "index" => 0
  "message" => array:2 [▼
    "role" => "assistant"
    "content" => "The age of the Earth is estimated to be around 4.54 billion years. This estimate is based on various scientific methods, including radiometric dating of rocks a ▶"
  ]
  "finish_reason" => "stop"
]
]
"usage" => array:3 [▼
"prompt_tokens" => 39
"completion_tokens" => 47
"total_tokens" => 86
]
]

*/

    // $answer = $answerFromAI['model'];


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        echo " this is store method";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}


// for ($y = 0; $y <= 10000000; $y++) {
//Tmbot::mbStart();
// echo "here index tmbot";
// $response = Telegram::getBotConfig();

// $commands = Telegram::bot('myfirstbot')->getChat();
// $response = Telegram::bot('myfirstbot')->getChat(['chat_id' => '909149522']);
// dd($response);
// $response = Telegram::bot('myfirstbot')->sendMessage([
// 	'chat_id' => '909149522',
// 	'text' => 'Hello World'
// ]);
// $response = Telegram::bot('myfirstbot')->getUserProfilePhotos(['botuser_id' => '5219853323']);

// $messageId = $response->getMessageId();


/*
foreach ($response[$cnt] as $key => $value) {
    if (array_key_exists($key, $array1)) {

        echo $key;
        echo "<br>";
        $array2[$key] = $value;
    }
}
foreach ($response[$cnt]['message'] as $key => $value) {
    if (array_key_exists($key, $array1)) {

        echo $key;
        echo "<br>";
        $array2[$key] = $value;
    }
}

foreach ($response[$cnt]['message']['chat'] as $key => $value) {
    if (array_key_exists($key, $array1)) {
        // $result[] = [$value];
        echo $key . " " . $value;
        echo "<br>";
        $array2[$key] = $value;
    }
}

$array2['botuser_id'] = $array2['id'];
$array2['content'] = $array2['text'];
unset($array2['id'], $array2['text']);
*/

// foreach ($x as $secs) {
// 	$t = microtime(true);
// 	sleepFloatSecs($secs);
// 	$t = microtime(true) - $t;
// 	echo "$secs \t => \t $t\n";
// }

// }
//


/* when message sent for AI chenge status = done*/
/*
    (array) $status = Tmbot::get('lastMessage');
    unset($_SESSION['lastMessage']);
    $status[0]['status'] = 'done';
    Tmbot::set('lastMessage', $status);


    foreach ($response as $msg => $value) {
        echo "<pre>";
        // dd($value);
        // print_r($value);

        echo " id user: " . $value['message']['from']['id'];
        echo " message from: " . $value['message']['from']['first_name'];
        echo " message id: " . $value['message']['message_id'];
        echo " text: " . $value['message']['text'];
        echo "<hr>";

        if (isset($value['message']['reply_to_message'])) {
            echo "<pre>";
            echo " ReplyToMessageFrom: " . $value['message']['reply_to_message']['from']['first_name'];

            if (isset($value['message']['reply_to_message']['from']['username'])) {
                echo " Username: " . $value['message']['reply_to_message']['from']['username'];
            }

            echo " idUser: " . $value['message']['reply_to_message']['from']['id'];
            echo " MessageId: " . $value['message']['reply_to_message']['message_id'];
            echo " Text: " . $value['message']['reply_to_message']['text'];
            echo "<hr>";
        }


        // print_r(" message from: " . $value['message']['from']['first_name'] . " text: " . $value['message']['text']);
        echo "</pre>";
    }

}
*/


// last message

/*
// checking status

$check_status = Tmbot::get('lastMessage');

if ($check_status[0]['status'] == null) {
    echo "this message has STATUS NULL !";
    echo "<br>";
    echo "from " . ($check_status[0]['first_name']);
    echo "<br>";
    echo "from " . ($check_status[0]['message_id']);
    echo "<br>";
    echo "sening to AI this text: " . ($check_status[0]['text']);


    //$aibot->index();
    echo "<br>";
    echo "change status to DONE ";

    $aibot->message = "Доброго дня! Меня звати " . ($check_status[0]['first_name']) . "Питання :" . ($check_status[0]['text']);
    $aibot->index();
    // echo $aibot->masseage_ans;
    echo "<br>";
*/

/* reply message */

/*
    Telegram::bot('myfirstbot')->sendMessage([
        'chat_id' => $check_status[0]['id'],
        'reply_to_message_id' => $check_status[0]['message_id'],
        'text' => $aibot->message_ans,
        'allow_sending_without_reply' => true
    ]);


    unset($_SESSION['lastMessage']);
    $check_status[0]['status'] = 'done';
    Tmbot::set('lastMessage', $check_status);
*/
