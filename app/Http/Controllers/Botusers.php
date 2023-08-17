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
use Telegram\Bot\Commands\CommandHandler;
use Telegram\Bot\Helpers\Update;

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
    protected ?ResponseCallBackQueryMessages $responseCallBackQueryMessages = null;
    protected ResponseObject $responseFromTmbot;

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

        Log::channel('stderr')->notice("botusers START");
        Log:
        info("botusers method start(),started");
//        Storage::append('myapp.log', date('H:i:s') . "botusers started");
//        echo " START ".time()."\n";

        (array)$responseFromTmbot = [];


        if ($this->botUserModel == null) {
//			echo "<font color='blue'>" . "NEW INSTANCE botUserModel " . "</font>";
            $this->botUserModel = app('botuser');
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

        $tmBotModel = $this->getModelTmBot();
        (object)$getLastRecordUpdate_id = $this->botMessageModel->getLastRecordUpdate_id();

        try {
            /**
             * $par = (Telegram::getConfig());
             * $par['client_options'] = [
             * 'verify' => false
             * ];
             * $par['http']['client_options'] = [
             * 'verify' => false
             * ];
             * Telegram::setConfig($par);
             */


            $responseFromTmbot = $this->telegram->bot($tmBotModel)->getUpdates(['offset' => $getLastRecordUpdate_id->update_id]);

            /**
             * $updates = new Update($responseFromTmbot[0]);
             * echo $updates->messageType();
             * if ($updates->messageType()) {
             * $rawResponse = $updates->getRawResponse();
             *
             * var_dump($rawResponse);
             * }
             */


            Log::info("Botusers,TM RESPONSE OK");
            Log::channel('stderr')->info("Botusers,TM RESPONSE OK");
        } catch (ConnectException|TelegramResponseException|TelegramSDKException $e) {
            Log::alert("Botusers,Telegram Exception : " . $e->getCode() . " : " . $e->getMessage());
//            $responseFromTmbot = null;
        }
        echo "\n";
//         dd(config()->get('botsmanagerconf.ENG.REPLYMARKUP_MENU_SUB_ONE'));
        $cnt = count($responseFromTmbot) - 1;
        Log::info('Botusers, total messages from updates' . $cnt);
        Log::channel('stderr')->info("Botusers, total messages from updates");
//        echo date("d/m/Y H:i:s") . " " . "total messages count: " . $cnt;
        echo "\n";


        for ($y = $cnt; $y >= 0; $y--) {
            if ($responseFromTmbot[$cnt]->__isset('callback_query')) {
                # BOT COMMAND

                // (isset($responseFromTmbot[$cnt]['callback_query'])) # old way
//              $userFound = $this->botUserModel->findByBotuser_id($responseFromTmbot[$cnt]['callback_query']['from']['id'] ?? 0);
                $answerCallbackQuery = false;
                $this->stdClassUser = $this->botUserModel->findByBotuser_id($responseFromTmbot[$cnt]['callback_query']['from']['id'] ?? 0);
                $this->responseCallBackQueryMessages = ResponseCallBackQueryMessages::ResponseCallBackQueryMessages($responseFromTmbot[$cnt]->collect());

                /**
                 * $callback_query = new stdClass();
                 * $callback_query->id = ($responseFromTmbot[$cnt]['callback_query']['id'] ?? 0);
                 * $callback_query->update_id = ($responseFromTmbot[$cnt]['update_id'] ?? 0);
                 * $callback_query->message_id = ($responseFromTmbot[$cnt]['callback_query']['message']['message_id'] ?? 0);
                 * $callback_query->botuser_id = ($responseFromTmbot[$cnt]['callback_query']['from']['id'] ?? 0);
                 * $callback_query->first_name = ($responseFromTmbot[$cnt]['callback_query']['from']['first_name'] ?? '');
                 * $callback_query->last_name = ($responseFromTmbot[$cnt]['callback_query']['from']['last_name'] ?? '');
                 * $callback_query->content = ($responseFromTmbot[$cnt]['callback_query']['data'] ?? '');
                 * $this->stdClassMsg->model_type = (int)$callback_query->content;
                 */
                (string)$msg_to_user = config()->get('botsmanagerconf.' . UsersMenu::cases()[$this->stdClassUser->lang]->name . '.INFO.role_change');
                try {

                    if (strcmp($responseFromTmbot[$cnt]['callback_query']['data'], "/cancel") !== 0) {
                        $answerCallbackQuery = $this->telegram->bot($tmBotModel)->answerCallbackQuery(
                            [
                                'callback_query_id' => $this->responseCallBackQueryMessages->id,
                                'text' => $msg_to_user,
                                'show_alert' => true,
                            ]);
                        $answerCallbackQuery = false;
                    }
                    $this->telegram->bot($tmBotModel)->editMessageReplyMarkup(
                        ['chat_id' => $this->responseCallBackQueryMessages->botuser_id,
                            'message_id' => $this->responseCallBackQueryMessages->message_id,
                            null,
                            null,
                        ]);

                } catch (ConnectException|TelegramResponseException|TelegramSDKException $e) {
                    Log::alert("Botusers,Telegram Exception : " . $e->getCode() . " : " . $e->getMessage());
                }
                if ($answerCallbackQuery) {
                    $this->responseCallBackQueryMessages->handlerCallBackQueryMessages($this->stdClassUser->id);
                }

                continue;
            } # end if callback_query

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

            # BOT COMMAND
            if (isset($responseFromTmbot[$cnt]['message']['entities']) ||
                isset($responseFromTmbot[$cnt]['edited_message']['entities'])) {
                if (strcmp($responseFromTmbot[$cnt]['message']['test'], "/start")) {
                    echo "accept BOT COMMAND";
                } else {
                    echo "NOT accept BOT COMMAND";
                    continue;
                }
            }

            if ($responseFromTmbot[$cnt]->__isset('message') or 'edited_message') {
                $this->responseMessages = ResponseMessages::ResponseMessages($responseFromTmbot[$cnt]->collect());
                $this->stdClassUser = $this->botUserModel->findByBotuser_id($this->responseMessages->botuser_id);

                //VALIDATE USER

                // SEARCH USER IN DATABASE IF RESPONSE message contains field: user_id
//            if ($this->responseMessages->botuser_id !== 0) {
                // echo "<pre>";
                // echo "MESSAGE FROM USER " . $this->stdClassMsg->first_name;
                // echo "</pre>";

            } else {
//                echo "<pre>";
//                echo date("d/m/Y H:i:s") . "-ERROR,IN ARRAY TMBOT NOT FOUND field user_id (responseFromTmbot[cnt][user_id])";
                Log::error('Botusers,ERROR,IN ARRAY TMBOT NOT FOUND field user_id (responseFromTmbot[cnt][user_id])');
                Log::channel('stderr')->error("Botusers,ERROR,IN ARRAY TMBOT NOT FOUND field user_id (responseFromTmbot[cnt][user_id])");

//                echo "\n";

                continue;
            }

            // IF USER NOT FOUND CREATE NEW USER

            if (($this->stdClassUser == null) and ($this->responseMessages->botuser_id !== 0)) {
                $this->newUsers = NewUsers::NewUsers($this->responseMessages->botuser_id)->createUser();
                $this->stdClassUser = $this->botUserModel->findByBotuser_id($this->responseMessages->botuser_id);
            }


//            (int)$messageIsExist = $this->botMessageModel->findIsMsgExistByMsg_id($this->stdClassMsg->message_id);
            (int)$messageIsExist = $this->botMessageModel->findIsMsgExistByMsg_id($this->responseMessages->message_id);

//            echo date("d/m/Y H:i:s") . " " . "this->stdClassMsg->content: ";
            print_r($this->responseMessages->content);
            echo "\n";
            //      $searchMenuCommandInContent = self::searchMenuCommandInContent($this->responseMessages->content)->name;

            switch (UsersStatus::cases()[$this->stdClassUser->status_usr]->name) {
                case ("NEW_USER"):
//                    echo date("d/m/Y H:i:s") . " " . "STATUS, NEW USER\n";
                    Log::info("Botusers,NEW USER ADDED by -> switch UsersStatus::cases");
                    Log::channel('stderr')->info("Botusers,NEW USER ADDED by -> switch UsersStatus::cases");

                    if (!$messageIsExist) {
                        self::handlerCasesNewUser(MessageStatus::REJECT);
                        /**
                         * $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($this->stdClassUser->id, $this->responseMessages);
                         * $this->botMessageModel->setStatusMessage($msg_pk_id, MessageStatus::REJECT);
                         * $this->userProfile = UserProfile::UserProfile($this->stdClassUser, $this->responseMessages)->setUpNewUserProfile();
                         */
                    }
                    break;
                case ("NOT_AUTHORIZED"):
//                    echo date("d/m/Y H:i:s") . " " . "STATUS, NOT_AUTHORIZED USER\n";
                    Log::info("Botusers, STATUS NOT_AUTHORIZED by -> switch UsersStatus::cases");
                    Log::channel('stderr')->info("Botusers, STATUS NOT_AUTHORIZED by -> switch UsersStatus::cases");
                    if (!$messageIsExist) {

                        if (!self::handlerCases(MessageStatus::REJECT)) {
                            /**
                             * $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($this->stdClassUser->id, $this->responseMessages);
                             * $this->botMessageModel->setStatusMessage($msg_pk_id, MessageStatus::REJECT);
                             * if ($searchMenuCommandInContent) {
                             * $this->userProfile = UserProfile::UserProfile($this->stdClassUser, $this->responseMessages, $msg_pk_id)->setUpUserSelectMenu();
                             * } else
                             */
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
                case
                ("AUTHORIZED"):
                    Log::info("Botusers, STATUS NOT_AUTHORIZED by -> switch UsersStatus::cases");
                    Log::channel('stderr')->info("Botusers, STATUS NOT_AUTHORIZED by -> switch UsersStatus::cases");

//                    echo date("d/m/Y H:i:s") . "STATUS, USER IS AUTHORIZED\n";

                    // $messageIsExist_ById = $this->botMessageModel->messageIsExist_ById($this->stdClassMsg->message_id);

                    if (!$messageIsExist) {
                        # here put handler
                        self::handlerCases(MessageStatus::NODELAY);
                        /**
                         * $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($this->stdClassUser->id, $this->responseMessages);
                         * $this->botMessageModel->setStatusMessage($msg_pk_id, MessageStatus::NODELAY);
                         * if ($searchMenuCommandInContent) {
                         * $this->userProfile = UserProfile::UserProfile($this->stdClassUser, $this->responseMessages, $msg_pk_id)->setUpUserSelectMenu();
                         * }
                         */
                        # end if $searchMenuCommandInContent
                    } # end if $messageIsExist


//                    echo date("d/m/Y H:i:s") . "STATUS, USER IS AUTHORIZED - FINESHED\n";

                    break;
                case ("VIOLATION"):
//                    echo date("d/m/Y H:i:s") . "STATUS, USER IS VIOLATION\n";
                    Log::info("Botusers, STATUS VIOLATION by -> switch UsersStatus::cases");
                    break;
                case ("OUT_OF_LIMIT"):
                    Log::info("Botusers, STATUS OUT_OF_LIMIT by -> switch UsersStatus::cases");
                    Log::channel('stderr')->info("Botusers, STATUS OUT_OF_LIMIT by -> switch UsersStatus::cases");
                    if (!$messageIsExist) {
                        if (!self::handlerCases(MessageStatus::DELAY)) /**
                         * $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($this->stdClassUser->id, $this->responseMessages);
                         * $this->botMessageModel->setStatusMessage($msg_pk_id, MessageStatus::DELAY);
                         * if ($searchMenuCommandInContent) {
                         * $this->userProfile = UserProfile::UserProfile($this->stdClassUser, $this->responseMessages, $msg_pk_id)->setUpUserSelectMenu();
                         * }
                         * else
                         */ {
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
                    Log::channel('stderr')->info('Botusers,something went wrong switch, by -> UsersStatus::cases');
//                    echo "<font color='red'>" . "something went wrong" . "</font>";
            } // END SWITCH

            $cnt--;
        } // -- end if iteration
//        echo "FINISH SLEEP ".time()."\n";
//        Storage::append('myapp.log', date('H:i:s') . "botusers stop");
        Log::info("botusers method, finished");
        Log::channel('stderr')->notice("botusers FINISH");
    } # ------------------------ END START -------------------------- #


    protected
    function getModelTmbot(): string
    {
        $data = (config('telegram'));
        $cnt = (array_keys($data['bots']));
        return ($cnt[1]);
        // [0] RenewalChristianChurch_Lviv_bot
        // [1] MyFisrtHHBot
    }

    protected
    function getChannelIdTmbot(): string
    {
        $data = (config('telegram'));
        $result = $data['bots']['first']['channel_id'];
        // dd($cnt);
        return ($result);
        // RenewalChristianChurch_Lviv_bot;
    }


    public
    function sendAnswerToUserTmbot(stdClass $replyToSendTmbot): bool
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

    public
    function sendMessageToUserTmbot(string $user_chat_id, string $message, ?string $reply_to_message_id = null, ?array $replyMarkup = null): bool
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

    public
    function deleteMessageToUserTmbot(string $user_chat_id, int $message_id): bool
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


    protected
    function searchMenuCommandInContent(string $content): object
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


    protected
    function handlerCases(MessageStatus $status): bool
    {
        $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($this->stdClassUser->id, $this->responseMessages);
        $this->botMessageModel->setStatusMessage($msg_pk_id, $status);
        $searchMenuCommandInContent = self::searchMenuCommandInContent($this->responseMessages->content)->name;

        if ($searchMenuCommandInContent) {
            $this->userProfile = UserProfile::UserProfile($this->stdClassUser, $this->responseMessages, $msg_pk_id)->setUpUserSelectMenu();
            return true;
        }
        return false;
    }

    protected
    function handlerCasesNewUser(MessageStatus $status): bool
    {
        $msg_pk_id = $this->botMessageModel->storeOnlyNewTmMesssages($this->stdClassUser->id, $this->responseMessages);
        $this->botMessageModel->setStatusMessage($msg_pk_id, $status);
        $this->userProfile = UserProfile::UserProfile($this->stdClassUser, $this->responseMessages)->setUpNewUserProfile();
        return true;
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

