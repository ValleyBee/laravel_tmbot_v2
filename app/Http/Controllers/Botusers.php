<?php

namespace App\Http\Controllers;


use App\Enums\Messages\Status as MessageStatus;
use App\Enums\Users\Status as UsersStatus;
use App\Enums\Users\UsersMenu;
use App\Http\Helpers\ResponseMessages;
use App\Http\Helpers\ResponseCallBackQueryMessages;
use App\Models\Botmessages as BotMessageModel;
use App\Models\Botuser as BotUserModel;
use App\Models\NewUsers;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\BotManager;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\ResponseObject;
use stdClass;
//use App\Jobs\SendQuestionAiDelay;


//use App\Jobs\StarterMethods;

// use Illuminate\Http\Request;

class Botusers extends Controller
{

    public function __construct()
    {
//        echo "THIS IS BOTUSERS CLASS";


    }

    public function __invoke()
    {
//        $this->start();
    }

    protected ?BotUserModel $botUserModel = null;
    protected ?UserProfile $userProfile = null;
    protected ?NewUsers $newUsers = null;
    protected ?stdClass $stdClassMsg = null;
    protected ?ResponseMessages $responseMessages = null;
    protected  ?ResponseCallBackQueryMessages $responseCallBackQueryMessages = null;
   protected  ResponseObject $responseFromTmbot;

    protected ?stdClass $stdClassUser = null;

    protected ?Botusers $botuserscontroller = null;
    protected ?BotManager $telegram = null;

    protected ?BotMessageModel $botMessageModel = null;


    public string $tmBotModel = '';


    public static function runner()
    {
        /** only one instance to be run. there is a loop inside method of updates */
        $instanceName = new Botusers();
        $instanceName->start();
//        while (!file_exists('../storage/logs/stop.txt')) {
//if (file_exists('../storage/logs/stop.txt')) {


    }

    public function test()
    {
        StarterMethods::dispatch();
        $path = public_path() . "session_last.txt";
//        file_put_contents($path, date("H:i:s"), null| LOCK_EX);
//        dd(file_get_contents($path));
//        Storage::put('last_session.data', date("H:i:s"));
//        dd(Storage::get('last_session.data', date("H:i:s")));
//        ($_SESSION["MODEL_LAST_TIME_USED"]);
//        dd(strtotime($_SESSION["MODEL_LAST_TIME_USED"]) - 3600);
//        config()->get('openai.free_response');
        (config()->get('botsmanagerconf.' . UsersMenu::cases()[3]->name . '.INFO.limit_have'));
        //      . " " . $this->botUserModel->getUserLimit($this->id)
        echo "CURRENT date: " . date("d:F");
        echo "CURRENT TIME: " . time();
        echo "CURRENT TIME- 60: " . time() - 60;
//        exit();
//        if (date("H:i:s") >= date("H:i:s", strtotime($_SESSION["MODEL_LAST_TIME_USED"]) - 120)) {
//            dd("YES");
//        }


        $d = Telegram::bot('first')->getStickerSet([
            'name' => 'Polar_Owl',
        ]);


        $msg_to_user = "\u{1F1F7}\u{1F1FA}\u{1F1FA}\u{1F1F8}\u{1f1fa}\u{1f1e6} Змінити мову";
        $botuser_id = 909149522;
        $message_id = null;
        $menu = config()->get('botsmanagerconf.ENG.REPLYMARKUP_MENU_MAIN');

        // dd($menu);
        // dd($menu['keyboard'][2][0]['text']);
        echo "<font color='red'>" . "CLASS TEST!" . "</font>";


//       dd(storage_path().'scheduler-output.log');

        // dd(config()->get('botsmanagerconf.' . UsersMenu::cases()[3]->name . '.NEWUSER.wait'));
        if ($this->botUserModel == null) {
//			echo "<font color='blue'>" . "NEW INSTANCE botUserModel " . "</font>";
            $this->botUserModel = app('botuser');

        }

        $result = $this->botUserModel->getUser(23);
        echo $result->id;
//		$par = (Telegram::getConfig());
//		$par['client_options'] = [
//			'verify' => false
//		];
//		$par['http']['client_options'] = [
//			'verify' => false
//		];
//
//		Telegram::setConfig($par);
//		dd((Telegram::getConfig()));
    }


    public function start()
    {

        Log::channel('stderr')->info("botusers method start(), started");
        Log:
        info("botusers method start(),started");
//        Storage::append('myapp.log', date('H:i:s') . "botusers started");
//        echo " START ".time()."\n";

//usleep(2 *1000);
        (string)$tmBotModel = '';
        (array)$responseFromTmbot = [];
        // (array)$responseFields = [];


        if ($this->botUserModel == null) {
//			echo "<font color='blue'>" . "NEW INSTANCE botUserModel " . "</font>";
            $this->botUserModel = app('botuser');
            // $this->botUserModel = resolve(BotUserModel::class);


            // $this->botUserModel = resolve(BotUserModel::class);
        }

        if ($this->stdClassMsg == null) {
            $this->stdClassMsg = new stdClass;
        }

        if ($this->stdClassUser == null) {
            $this->stdClassUser = new stdClass;
        }
        if ($this->telegram == null) {
            $this->telegram = app('telegram');
        }
        if ($this->botMessageModel === null) {
            $this->botMessageModel = app('botmessage');
        }


        // echo 'this is Botusers class';


        $tmBotModel = $this->getModelTmBot();

        (object)$getLastRecordUpdate_id = $this->botMessageModel->getLastRecordUpdate_id();

        //         if ($getLastRecordUpdate_id->update_id = null) {
//
//         }
        try {
            /*
            $par = (Telegram::getConfig());
            $par['client_options'] = [
                'verify' => false
            ];
            $par['http']['client_options'] = [
                'verify' => false
            ];
            Telegram::setConfig($par);
*/


            $responseFromTmbot = $this->telegram->bot($tmBotModel)->getUpdates(['offset' => $getLastRecordUpdate_id->update_id]);
//            $responseFromTmbot = $this->telegram->bot($tmBotModel)->getUpdates();
            Log::info("Botusers,RESPONSE FROM TM OK");
        } catch (ConnectException|TelegramResponseException|TelegramSDKException $e) {
            Log::alert("Botusers,Telegram Exception : " . $e->getCode() . " : " . $e->getMessage());
//            $responseFromTmbot = null;
        }

        echo "\n";


        // self::createMenuTmbot();
        // self::removeMenuTmbot();


//         dd(config()->get('botsmanagerconf.ENG.REPLYMARKUP_MENU_SUB_ONE'));

//        $cnt = count($responseFromTmbot) - 1; # old way
        $cnt = $responseFromTmbot[0]->count()-1;
        Log::info('Botusers, total messages from updates' . $cnt);
        echo date("d/m/Y H:i:s") . " " . "total messages : " . count($responseFromTmbot);

        echo "\n";


        for ($y = $cnt; $y >= 0; $y--) {

            echo ($responseFromTmbot[$cnt]->__isset('callback_query'));
            echo "\n";
            if ($responseFromTmbot[$cnt]->__isset('callback_query')) {
//            (isset($responseFromTmbot[$cnt]['callback_query'])) # old way

                $responseCallBack = false;
                $this->responseCallBackQueryMessages = ResponseCallBackQueryMessages::ResponseCallBackQueryMessages($responseFromTmbot[$cnt]->collect());
/**
                $callback_query = new stdClass();
                $callback_query->id = ($responseFromTmbot[$cnt]['callback_query']['id'] ?? 0);
                $callback_query->update_id = ($responseFromTmbot[$cnt]['update_id'] ?? 0);
                $callback_query->message_id = ($responseFromTmbot[$cnt]['callback_query']['message']['message_id'] ?? 0);
                $callback_query->botuser_id = ($responseFromTmbot[$cnt]['callback_query']['from']['id'] ?? 0);
                $callback_query->first_name = ($responseFromTmbot[$cnt]['callback_query']['from']['first_name'] ?? '');
                $callback_query->last_name = ($responseFromTmbot[$cnt]['callback_query']['from']['last_name'] ?? '');
                $callback_query->content = ($responseFromTmbot[$cnt]['callback_query']['data'] ?? '');

                $this->stdClassMsg->model_type = (int)$callback_query->content;
*/
                $userFound = $this->botUserModel->findByBotuser_id($this->responseCallBackQueryMessages->botuser_id);

                (string)$msg_to_user = config()->get('botsmanagerconf.' . UsersMenu::cases()[$userFound->lang]->name . '.INFO.roll_change');
//
                try {
                    $responseCallBack = $this->telegram->bot($tmBotModel)->answerCallbackQuery(
                        [
                            'callback_query_id' => $this->responseCallBackQueryMessages->id,
                            'text' => $msg_to_user,
                            'show_alert' => true,
                        ]);
                    $this->telegram->bot($tmBotModel)->editMessageReplyMarkup(
                        ['chat_id' => $this->responseCallBackQueryMessages->botuser_id,
                        'message_id' => $this->responseCallBackQueryMessages->message_id,
                            null,
                            null,
                        ]);

                } catch (ConnectException|TelegramResponseException|TelegramSDKException $e) {
                    Log::alert("Botusers,Telegram Exception : " . $e->getCode() . " : " . $e->getMessage());
                }
                if ($responseCallBack) {

                    $userFound = $this->botUserModel->findByBotuser_id($this->responseCallBackQueryMessages->botuser_id);
                    $this->botUserModel->setUserRollModel($userFound->id, (int)$this->responseCallBackQueryMessages->content);
                    $messageIsExist = $this->botMessageModel->findIsMsgExistByMsg_id($this->responseCallBackQueryMessages->message_id);
                    if (!$messageIsExist) {
                        $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($userFound->id, $this->responseCallBackQueryMessages);
                        $this->botMessageModel->setStatusMessage($msg_pk_id, MessageStatus::MENU);

                    }
                }
//exit();
                continue;
            }

            if (isset($responseFromTmbot[$cnt]['my_chat_member'])) {
                //            update_id: 785629015
                //    my_chat_member: array:5 [▼
                //      "chat" => array:3 [▶]
                //      "from" => array:5 [▶]
                //      "date" => 1691062362
                //      "old_chat_member" => array:2 [▶]
                //      "new_chat_member" => array:14 [▶]
                // }
                continue;
            }


            if (isset($responseFromTmbot[$cnt]['message'])) {
                $msg = "message";
            }
            if (isset($responseFromTmbot[$cnt]['edited_message'])) {
                $msg = 'edited_message';
            }




            $this->responseMessages = ResponseMessages::ResponseMessages($responseFromTmbot[$cnt]->collect());
//
//            $this->stdClassMsg =
            //            (object)$this->stdClassMsg = (object)(array)$this->messages;

/**
            $this->stdClassMsg->update_id = ($responseFromTmbot[$cnt]['update_id'] ?? 0);
            $this->stdClassMsg->message_id = ($responseFromTmbot[$cnt][$msg]['message_id'] ?? 0);
            $this->stdClassMsg->botuser_id = ($responseFromTmbot[$cnt][$msg]['from']['id'] ?? 0);
            $this->stdClassMsg->first_name = ($responseFromTmbot[$cnt][$msg]['from']['first_name'] ?? '');
            $this->stdClassMsg->last_name = ($responseFromTmbot[$cnt][$msg]['from']['last_name'] ?? '');
            $this->stdClassMsg->content = ($responseFromTmbot[$cnt][$msg]['text'] ?? '');
*/
//            dd($this->stdClassMsg);



//			 dd($this->stdClassMsg);

            // $this->botUserModel->changeUserStatus();
            //VALIDATE USER
            // dd(UsersStatus::cases()[$resultStatus($userFoundId)]->name);

            /*
    case NOT_AUTHORIZED = 0;
    case AUTHORIZED = 1;
    case BAN_TIME1 = 2;
    case BAN_TIME2 = 3;
    case REJECT = 4;
    case VIOLATION = 5;
    case DELETED = 9; */
            /*
            $resultStatus = function (int $id): int {
                return $this->botUserModel->getUserStatus($id);
            };
*/

            // SEARCH USER IN DATABASE IF RESPONSE message contains field: user_id
            if ($this->responseMessages->botuser_id !== 0) {
                // echo "<pre>";
                // echo "MESSAGE FROM USER " . $this->stdClassMsg->first_name;
                // echo "</pre>";
                $this->stdClassUser = $this->botUserModel->findByBotuser_id($this->responseMessages->botuser_id);
//                $this->stdClassUser = $this->botUserModel->findByBotuser_id($this->stdClassMsg->botuser_id);
            } else {
//                echo "<pre>";
//                echo date("d/m/Y H:i:s") . "-ERROR,IN ARRAY TMBOT NOT FOUND field user_id (responseFromTmbot[cnt][user_id])";
                Log::error('Botusers,ERROR,IN ARRAY TMBOT NOT FOUND field user_id (responseFromTmbot[cnt][user_id])');
                echo "\n";

                continue;
            }


            // IF USER NOT FOUND CREATE NEW USER

            if (($this->stdClassUser == null) and ($this->responseMessages->botuser_id !== 0)) {

                $this->newUsers = NewUsers::NewUsers($this->stdClassMsg->botuser_id)->createUser();
                $this->stdClassUser = $this->botUserModel->findByBotuser_id($this->responseMessages->botuser_id);

            }


//            (int)$messageIsExist = $this->botMessageModel->findIsMsgExistByMsg_id($this->stdClassMsg->message_id);
            (int)$messageIsExist = $this->botMessageModel->findIsMsgExistByMsg_id($this->responseMessages->message_id);

//            echo date("d/m/Y H:i:s") . " " . "this->stdClassMsg->content: ";
            print_r($this->responseMessages->content);
            echo "\n";
            $searchMenuCommandInContent = self::searchMenuCommandInContent($this->responseMessages->content)->name;
            // dd($searchMenuCommandInContent);
            // $searchMenuCommandInContent2 = self::searchMenuCommandInContent($this->stdClassMsg->content)->name;

//            echo date("d/m/Y H:i:s") . " searchMenuCommandInContent : " . $searchMenuCommandInContent;
            echo "\n";
            // dd(UsersStatus::cases()[$resultStatus($userFoundId)]->name);
            switch (UsersStatus::cases()[$this->stdClassUser->status_usr]->name) {
                case ("NEW_USER"):
//                    echo date("d/m/Y H:i:s") . " " . "STATUS, NEW USER\n";
                    Log::info("Botusers,NEW USER ADDED by -> switch UsersStatus::cases");
                    if (!$messageIsExist) {
                        $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($this->stdClassUser->id, $this->responseMessages);
                        $this->botMessageModel->setStatusMessage($msg_pk_id, MessageStatus::REJECT);
                        $this->userProfile = UserProfile::UserProfile($this->stdClassUser, $this->responseMessages)->setUpNewUserProfile();
                    }
                    // $this->botUserModel->changeUserStatus($this->stdClassUser->id, UsersStatus::NOT_AUTHORIZED);

                    // self::sendMessageToUserTmbot($this->stdClassMsg, $msg1 . $msg3 . $msg2);

                    break;
                case ("NOT_AUTHORIZED"):
//                    echo date("d/m/Y H:i:s") . " " . "STATUS, NOT_AUTHORIZED USER\n";
                    Log::info("Botusers, STATUS NOT_AUTHORIZED by -> switch UsersStatus::cases");
                    if (!$messageIsExist) {
                        $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($this->stdClassUser->id, $this->responseMessages);
                        $this->botMessageModel->setStatusMessage($msg_pk_id, MessageStatus::REJECT);
                        if ($searchMenuCommandInContent) {
//                                echo  date("d/m/Y H:i:s"). "message ID: " . $this->stdClassMsg->message_id;
//                                echo "\n";
                            $this->userProfile = UserProfile::UserProfile($this->stdClassUser, $this->responseMessages, $msg_pk_id)->setUpUserSelectMenu();
                        } else {
                            // dd($msg_to_user);
                            (string)$msg_to_user = config()->get('botsmanagerconf.' . UsersMenu::cases()[$this->stdClassUser->lang]->name . '.NEWUSER.wait');
                            self::sendMessageToUserTmbot(
                                $this->responseMessages->botuser_id,
                                $msg_to_user,
                                $this->responseMessages->message_id,
                                null

                            );
                        } # end if $searchMenuCommandInContent
                    } # end if $messageIsExist

                    //	self::deleteMessageToUserTmbot(5388563391, 1207);

                    /*
                    (string)$msg1 = "\xE2\x9E\xA1 Please wait for a messages of your authorization.\n";
                    (string)$msg2 = "\xE2\x9E\xA1 Пожалуйста,ожидайте сообщение о вашей авторизации.\n";
                    (string)$msg3 = "\xE2\x9E\xA1 Будь-ласка,очикуйте на повідомлення про вашу авторізвцію.\n";
                    */

                    break;
                case ("AUTHORIZED"):
                    Log::info("Botusers, STATUS NOT_AUTHORIZED by -> switch UsersStatus::cases");
//                    echo date("d/m/Y H:i:s") . "STATUS, USER IS AUTHORIZED\n";

                    // $messageIsExist_ById = $this->botMessageModel->messageIsExist_ById($this->stdClassMsg->message_id);

                    if (!$messageIsExist) {
                        $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($this->stdClassUser->id, $this->responseMessages);
                        $this->botMessageModel->setStatusMessage($msg_pk_id, MessageStatus::NODELAY);
                        if ($searchMenuCommandInContent) {
                            $this->userProfile = UserProfile::UserProfile($this->stdClassUser, $this->responseMessages, $msg_pk_id)->setUpUserSelectMenu();
                        } # end if $searchMenuCommandInContent
                    } # end if $messageIsExist


//                    echo date("d/m/Y H:i:s") . "STATUS, USER IS AUTHORIZED - FINESHED\n";

                    break;
                case ("VIOLATION"):
//                    echo date("d/m/Y H:i:s") . "STATUS, USER IS VIOLATION\n";
                    Log::info("Botusers, STATUS VIOLATION by -> switch UsersStatus::cases");
                    break;
                case ("OUT_OF_LIMIT"):
                    Log::info("Botusers, STATUS OUT_OF_LIMIT by -> switch UsersStatus::cases");
                    echo date("d/m/Y H:i:s") . " STATUS, OUT_OF_LIMIT\n";
                    if (!$messageIsExist) {
                        $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($this->stdClassUser->id, $this->responseMessages);
                        $this->botMessageModel->setStatusMessage($msg_pk_id, MessageStatus::DELAY);

                        if ($searchMenuCommandInContent) {
//                            dd("searchMenuCommandInContent");
                            $this->userProfile = UserProfile::UserProfile($this->stdClassUser, $this->responseMessages, $msg_pk_id)->setUpUserSelectMenu();
                        } else {
                            (string)$msg_to_user = config()->get('botsmanagerconf.' . UsersMenu::cases()[$this->stdClassUser->lang]->name . '.INFO.limit_out');
                            $msg_to_user .= "\n" . config()->get('botsmanagerconf.' . UsersMenu::cases()[$this->stdClassUser->lang]->name . '.INFO.limit_out_delay');
                            self::sendMessageToUserTmbot(
                                $this->responseMessages->botuser_id,
                                $msg_to_user,
                                $this->responseMessages->message_id,
                                null
                            );
                        } # end if $searchMenuCommandInContent


                    } # end if $messageIsExist

                    // echo "SORRY, YOU HAVE USED ALL LIMITS ON REQUEST";
                    // (string)$msg1 = "\xE2\x9E\xA1 SORRY, YOU HAVE USED ALL LIMITS ON REQUEST.\n";
                    // self::sendMessageToUserTmbot(
                    // 	$this->stdClassMsg->user_id,
                    // 	$this->stdClassMsg->message_id,
                    // 	$msg1
                    // );
                    break;
                default:
                    Log::alert('Botusers,something went wrong switch, by -> UsersStatus::cases');
//                    echo "<font color='red'>" . "something went wrong" . "</font>";
            } // END SWITCH

            $cnt--;
        } // -- end if iteration
//        echo "FINISH SLEEP ".time()."\n";
//        Storage::append('myapp.log', date('H:i:s') . "botusers stop");
        Log::info("botusers method start(), finished");
        Log::channel('stderr')->info("botusers method start(), finished");
    } # ------------------------ END START -------------------------- #


    protected function getModelTmbot(): string
    {
        $data = (config('telegram'));
        $cnt = (array_keys($data['bots']));
        return ($cnt[1]);
        // [0] RenewalChristianChurch_Lviv_bot
        // [1] MyFisrtHHBot
    }

    protected function getChannelIdTmbot(): string
    {
        $data = (config('telegram'));
        $result = $data['bots']['first']['channel_id'];
        // dd($cnt);
        return ($result);
        // RenewalChristianChurch_Lviv_bot;
    }


    public function sendAnswerToUserTmbot(stdClass $replyToSendTmbot): bool
    {
        // $answer = ['choices'][0]['message']['content'];

        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
        }
        if ($this->telegram === null) {
            $this->telegram = app('telegram');
        }


        // exit();
        $tmBotModel = self::getModelTmBot();
        try {
            $this->telegram->bot($tmBotModel)->sendMessage([
                'chat_id' => $replyToSendTmbot->botuser_id,
                'reply_to_message_id' => $replyToSendTmbot->message_id,
                'text' => "ID:" . $replyToSendTmbot->message_id . "\n" . "\u{1F170}" . $replyToSendTmbot->reply_from_ai,
                'allow_sending_without_reply' => true
            ]);
        } catch (ConnectException|TelegramResponseException|TelegramSDKException $e) {
            echo "Telegram Exception : " . $e->getCode() . " : " . $e->getMessage();
            exit();
        }

        return true;
    }

    public function sendMessageToUserTmbot(string $user_chat_id, string $message, ?string $reply_to_message_id = null, ?array $replyMarkup = null): bool
    {

        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
        }
        if ($this->telegram === null) {
            $this->telegram = app('telegram');
        }

        $tmBotModel = self::getModelTmBot();
        (array)$fields = [
            'chat_id' => $user_chat_id,
            'reply_to_message_id' => $reply_to_message_id,
            'text' => $message,
            'allow_sending_without_reply' => true,
            'parse_mode' => 'Markdown'

        ];
        if ($replyMarkup !== null) {
            $fields['reply_markup'] = $replyMarkup;
        }

        try {
            $this->telegram->bot($tmBotModel)->sendMessage($fields);
        } catch (ConnectException|TelegramResponseException|TelegramSDKException $e) {
            echo "<font color='red'>" . "Telegram Exception : " . $e->getCode() . " : " . $e->getMessage() . "</font>";
            exit();
        }

        return true;
    }

    public function deleteMessageToUserTmbot(string $user_chat_id, int $message_id): bool
    {
        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
        }
        if ($this->telegram === null) {
            $this->telegram = app('telegram');
        }


        $tmBotModel = self::getModelTmBot();

        (array)$fields = [
            'chat_id' => $user_chat_id,
            'message_id' => $message_id,
        ];


        try {
            $this->telegram->bot($tmBotModel)->deleteMessage($fields);
        } catch (ConnectException|TelegramResponseException|TelegramSDKException $e) {
            echo "Telegram Exception : " . $e->getCode() . " : " . $e->getMessage();
            exit();
        }

        return true;
    }


    public function searchMenuCommandInContent(string $content): object
    {
        echo $content;
        foreach (UsersMenu::cases() as $key => $value) {
            foreach (UsersMenu::cases()[$key]->text() as $result) {

                if ($content == $result) return UsersMenu::cases()[$key];
            };
        }
        $stdClass = new stdClass();
        $stdClass->name = null;
        $stdClass->value = null;
        return $stdClass;
    }

    /*
    public function getValueMenuByContent(string $content): stdClass
    {
        foreach (UsersMenu::cases() as $key => $value) {
            foreach (UsersMenu::cases()[$key]->text() as $result) {
                if ($content == $result) return UsersMenu::cases()[$key];
            };
        }
        $stdClass = new stdClass();
        $stdClass->name = null;
        $stdClass->value = null;
        return $stdClass;
    }
    */

}

