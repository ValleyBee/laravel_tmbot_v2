<?php

namespace App\Http\Controllers;

use App\Enums\Messages\Status as MessageStatus;
use App\Enums\Users\Status as UsersStatus;
use App\Enums\Users\UsersMenu;
use Illuminate\Support\Facades\Log;
use App\Http\Helpers\ResponseMessages;
use stdClass;


/*----------------------------------part 2 ------- methods for adminpanel*/

class UserProfile extends Botusers
{
    protected int $id;

    protected string $botuser_id;
    protected string $update_id;
    protected int $status_usr;
    protected int $model_type;
    protected int $limit_req_num;
    protected int $lang;

    protected int $msg_pk_id;
    protected int $message_id;
    protected string $first_name;
    protected string $last_name;
    protected string $content;


    protected function __construct(
        int    $id,
        string $botuser_id,
        string $update_id,
        int    $status_usr,
        int    $model_type,
        int    $limit_req_num,
        int    $lang,
        int    $message_id,
        string $first_name,
        string $last_name,
        string $content,
        int    $msg_pk_id,

    )
    {
        $this->id = $id;
        $this->botuser_id = $botuser_id;
        $this->update_id = $update_id;
        $this->status_usr = $status_usr;
        $this->model_type = $model_type;
        $this->limit_req_num = $limit_req_num;
        $this->lang = $lang;
        $this->message_id = $message_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->content = $content;
        $this->msg_pk_id = $msg_pk_id;
    }

    public static function UserProfile(stdClass $stdClassUser, ResponseMessages $stdClassMsg, ?int $msg_pk_id = 0): UserProfile
    {
        return new UserProfile(
            $stdClassUser->id,
            $stdClassUser->botuser_id,
            $stdClassMsg->update_id,
            $stdClassUser->status_usr,
            $stdClassUser->model_type,
            $stdClassUser->limit_req_num,
            $stdClassUser->lang,
            $stdClassMsg->message_id,
            $stdClassMsg->first_name,
            $stdClassMsg->last_name,
            $stdClassMsg->content,
            $msg_pk_id

        );
    }

    # ENG 🇺🇸 RU 🇷🇺 UA 🇺🇦
    protected function setUpNewUserProfile()
    {

        (string)$msg_to_user = implode(" ", (array)config()->get(['botsmanagerconf.ENG.MENU.chclang', 'botsmanagerconf.UA.MENU.chclang', 'botsmanagerconf.RU.MENU.chclang']));
        (string)$msg2 = "del menu|";
        if ($this->botMessageModel === null) {
            $this->botMessageModel = app('botmessage');
        }
        if ($this->botUserModel == null) {
            $this->botUserModel = app('botuser');
        }

        /*

        (object)$user_found = null;
        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
            // $this->botUserModel = resolve(Botuser::class);
        }
        try {
            $user_found = $this->botUserModel->getUser($this->id);

            // $user_found = self::getUser($user->id);
            if (is_null($user_found)) {
                echo ('USER NOT FOUND  error message');
                // return abort(404);
                return $user_found;
            }

            // $userData->status_usr = $userStatus->value;
            // ['status' => $userStatus->value]
            // $user_found->update();
        } catch (QueryException $e) {
            echo $e;
        }
*/

        /*
        foreach ((array_column(UsersLang::cases(), 'value')) as $lang) {
            foreach (UsersLang::cases()[$lang] as $l) {
                if ($this->content == $l) {
                    echo "YES";
                };
            }
        }*/

        // dd($this->content);
        /*
        if ((UsersLang::cases()[$this->id]->name) == 'NONE') {
            echo "none lang choice";
            parent::sendMessageToUserTmbot($this->user_id, $this->message_id, $msg1, self::createMenuTmbot());
        } else {
            parent::sendMessageToUserTmbot($this->user_id, $this->message_id, $msg2, self::removeMenuTmbot());
        }
*/


        // switch (UsersMenu::cases()[$this->lang]->name) {
        // 	case ("NONE"):
        /*
                if (parent::searchMenuCommandInContent($this->content)) {
                    echo "MENE LANGUAGE IT IS WORKING!!!!";
                }

*/


        $sendMsgWithMenuToUser = function (string $msg_to_user, array $menu) {
            parent::sendMessageToUserTmbot(
                $this->botuser_id,
                $msg_to_user,
                null,
                $menu
            );
        };

        $getNameValueMenu = parent::searchMenuCommandInContent($this->content);

//        if ($getNameValueMenu->value) {

        switch ($getNameValueMenu->name) {
            case ("ENG"):
            case ("RU"):
            case ("UA"):
                $this->botUserModel->changeUserStatus($this->id, UsersStatus::NOT_AUTHORIZED);
                $this->botUserModel->setUserlang($this->id, $getNameValueMenu->value);
                (string)$msg_to_user = config()->get('botsmanagerconf.' . $getNameValueMenu->name . '.MENU.chslang');
                $menu = self::keyboardMainMenuTmbot($getNameValueMenu->name);
                parent::sendMessageToUserTmbot(
                    $this->botuser_id,
                    $msg_to_user,
                    $this->message_id,
                    $menu
                );
                break;
            case ("MODEL_ONE"):

                break;
            case ("START_OVER"):
                (string)$msg_to_user = implode(" ", (array)config()->get(['botsmanagerconf.ENG.MENU.chclang', 'botsmanagerconf.UA.MENU.chclang', 'botsmanagerconf.RU.MENU.chclang']));
                $menu = self::keyboardLangMenuTmbot();
                $sendMsgWithMenuToUser($msg_to_user, $menu);
                break;
            default:
                (string)$msg_to_user = implode(" ", (array)config()->get(['botsmanagerconf.ENG.MENU.chclang', 'botsmanagerconf.UA.MENU.chclang', 'botsmanagerconf.RU.MENU.chclang']));
                $sendMsgWithMenuToUser($msg_to_user, self::keyboardLangMenuTmbot());
                echo "<font color='#483d8b'>" . "default case, user didn't choice LANG menu buttons" . "</font>";
//echo "<font color='red'>" . "Something went NOT wrong with SWITCH CASES" . "</font>";
//                    exit();
        }

//		} else {
//            (string)$msg_to_user = implode(" ", (array)config()->get(['botsmanagerconf.ENG.MENU.chclang', 'botsmanagerconf.UA.MENU.chclang',  'botsmanagerconf.RU.MENU.chclang']));
//            $sendMsgWithMenuToUser($msg_to_user,self::keyboardLangMenuTmbot());
//
//		}

        // break;
        // } // end of switch
    }

    protected function setUpUserSelectMenu()
    {
        if ($this->botMessageModel === null) {
            $this->botMessageModel = app('botmessage');
        }
        if ($this->botUserModel == null) {
            $this->botUserModel = app('botuser');
        }
        /* ENG 🇺🇸 RU 🇷🇺 UA 🇺🇦*/
        // dd($this->stdClassMsg);

        // $msg_pk_id = $this->botMessageModel->getMessageByMsg_Id($this->message_id);
        $this->botMessageModel->setStatusMessage($this->msg_pk_id, MessageStatus::MENU);


        $getNameValueMenu = parent::searchMenuCommandInContent($this->content);
        if ($getNameValueMenu->name == null) {
            Log::error("NOT FOUND COMMAND IN MENU! by -> UserProfile ->setUpUserSelectMenu");
            //            echo "<font color='red'>" . "NOT FOUND COMMAND IN MENU!" . "</font>";
//            exit();
        }

        $msg_to_user = 'menu select';
        // $menu = self::keyboardMainMenuTmbot($getNameValueMenu);
        echo "getNameValueMenu: " . 'botsmanagerconf.' . $getNameValueMenu->name . '.MENU.chslang';

        $setUpLanguage = function () use ($getNameValueMenu) {
            $this->botUserModel->setUserlang($this->id, $getNameValueMenu->value);
        };

        $sendMsgWithMenuToUser = function (string $msg_to_user, array $menu) {
            parent::sendMessageToUserTmbot(
                $this->botuser_id,
                $msg_to_user,
                null,
                $menu
            );
        };
        $sendMsgWithoutMenuToUser = function (string $msg_to_user) {
            parent::sendMessageToUserTmbot(
                $this->botuser_id,
                $msg_to_user,
                null,
                null
            );
        };

        // dd($resultValueMenu);

        // self::removeMenuTmbot();
        //self::createMenuTmbot()

        switch ($getNameValueMenu->name) {
            case ("NONE"):

                break;
            case ("ENG"):
            case ("RU"):
            case ("UA"):
                $setUpLanguage();
                (string)$msg_to_user = config()->get('botsmanagerconf.' . $getNameValueMenu->name . '.MENU.chslang');
                (array)$menu = self::keyboardMainMenuTmbot($getNameValueMenu->name);
                $sendMsgWithMenuToUser($msg_to_user, $menu);
                break;
            case ("CNG_LANG"):
            case ("START_OVER"):
                (string)$msg_to_user = implode(" ", (array)config()->get(['botsmanagerconf.ENG.MENU.chclang', 'botsmanagerconf.UA.MENU.chclang', 'botsmanagerconf.RU.MENU.chclang']));
                $menu = self::keyboardLangMenuTmbot();
                $sendMsgWithMenuToUser($msg_to_user, $menu);
                break;
            case ("SUB_MENU"):
                $lang_name = UsersMenu::cases()[$this->lang]->name ?? UsersMenu::ENG->name;
                (string)$msg_to_user = config()->get('botsmanagerconf.' . $lang_name . '.INFO.ai_questions');
                (array)$menu = self::keyboardSubMenuTmbot($lang_name);
                $sendMsgWithMenuToUser($msg_to_user, $menu);
                break;
            case("BACK_MAIN"):

                $lang_name = UsersMenu::cases()[$this->lang]->name ?? UsersMenu::ENG->name;
                (string)$msg_to_user = config()->get('botsmanagerconf.' . $lang_name . '.INFO.back_main_menu');
                (array)$menu = self::keyboardMainMenuTmbot($lang_name);
                $sendMsgWithMenuToUser($msg_to_user, $menu);
                break;
            case ("CHK_LIMIT"):

                (string)$msg_to_user = config()->get('botsmanagerconf.' .
                        UsersMenu::cases()[$this->lang]->name . '.INFO.limit_have') . " " .
                    $this->botUserModel->getUserLimit($this->id);

                $sendMsgWithoutMenuToUser($msg_to_user);
                break;
            case ("ROLL_AI"):
                $lang_name = UsersMenu::cases()[$this->lang]->name ?? UsersMenu::ENG->name;
                (string)$msg_to_user = config()->get('botsmanagerconf.' . $lang_name . '.INFO.assigning_roles');
                (array)$menu = self::keyboardRollMenuTmbot($lang_name);
                $sendMsgWithMenuToUser($msg_to_user, $menu);
                break;


            default:
                Log::alert('something went wrong switch, by -> UserProfile ->setUpUserSelectMenu');
//                echo "<font color='red'>" . "Something went wrong with SWITCH CASES" . "</font>";

        }


        //  $this->getValueMenuByContent($this->content)->name);


    }


    // $this->botUserModel->changeUserStatus($this->stdClassUser->id, UsersStatus::NOT_AUTHORIZED);

    protected function keyboardMainMenuTmbot(string $name_lang): array
    {
        return config()->get('botsmanagerconf.' . $name_lang . '.REPLYMARKUP_MENU_MAIN');
    }

    protected function keyboardSubMenuTmbot(string $name_lang): array
    {
        return config()->get('botsmanagerconf.' . $name_lang . '.REPLYMARKUP_MENU_SUB_ONE');
    }
    protected function keyboardRollMenuTmbot(string $name_lang): array
    {
        return config()->get('botsmanagerconf.' . $name_lang . '.REPLYMARKUP_MENU_INLINE');
    }

    protected function keyboardLangMenuTmbot(): array
    {

        // $replyMarkup = array(
        // 	'inline_keyboard' => array(
        // 		array(
        // 			array(
        // 				'text' => 'ENG',
        // 				'callback_data' => 'test_1',
        // 			),

        // 			array(
        // 				'text' => 'RU',
        // 				'callback_data' => 'test_2',
        // 			),
        // 			array(
        // 				'text' => 'UA',
        // 				'callback_data' => 'test_3',
        // 			),
        // 		)
        // 	),
        // 	'one_time_keyboard' => true,
        // 	'resize_keyboard' => true
        // );

        return config()->get('botsmanagerconf.REPLYMARKUP_MENU_LANG');
        /*
        return $replyMarkup = array(
            'keyboard' => array(
                array(
                    array(
                        'text' => 	"RU \u{1F1F7}\u{1F1FA}",
                    ),

                    array(
                        'text' => "ENG \u{1F1FA}\u{1F1F8}",

                    ),
                    array(
                        'text' => "UA \u{1f1fa}\u{1f1e6}",

                    ),
                )
            ),
            'one_time_keyboard' => true,
            'resize_keyboard' => true,
            'input_field_placeholder' => 'make your choice'
        );

*/
        // $remv =
        // 	array(
        // 		'remove_keyboard' => true,
        // 	);


        // {"keyboard":[["button","one","two","three"],["Currency","Menu"],["1","2","3"],["4"]],"resize_keyboard":true,"one_time_keyboard":false} );

        // $marks = [
        // 	"mohan" => ["maths" => 85, "sci" => 75, "sst" => 65],
        // 	"sohan" => ["maths" => 74, "sci" => 78, "sst" => 12],
        // 	"rohan" => ["maths" => 45, "sci" => 78, "sst" => 41],
        // ];
        // );

        // $rm = ReplyKeyboardMarkup(
        // 	keyboard => array(
        // 		array(KeyboardButton("Yes, they certainly are!")),
        // 		array(KeyboardButton("I'm not quite sure")),
        // 		array(KeyboardButton("No..."))
        // 	),
        // 	resize_keyboard = FALSE,
        // 	one_time_keyboard = FALSE
        // )

        // $replyMarkup =  array(
        // 	'remove_keyboard' => true
        // );
//
//		$keyboard = [
//			['7', '8', '9'],
//			['4', '5', '6'],
//			['1', '2', '3'],
//			['0']
//		];
        // $encodedMarkup = json_encode($replyMarkup);

    }


    protected function removeMenuTmbot(): array
    {
        return config()->get('botsmanagerconf.REPLYMARKUP_MENU_RM');

        // return $replyMarkup =  array(
        // 	'remove_keyboard' => true
        // );


        // return $fields = [
        // 	'chat_id' => '909149522',
        // 	'text' => 'Hello World',
        // 	'reply_markup' => $replyMarkup
        // ];
    }
} # end UserProfile
