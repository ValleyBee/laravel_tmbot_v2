<?php

namespace App\Enums\Users;

enum UsersMenu: int
{
    case NONE = 0;
    case RU = 1;
    case ENG = 2;
    case UA = 3;
    case SUB_MENU = 4;
//    case CNG_LANG = 5;
    case CHK_LIMIT = 6;
    case ROLL_AI = 7;
    case START_OVER = 8;
    case BACK_MAIN = 9;


    public function text()
    {
        $menuLang = config()->get('botsmanagerconf.REPLYMARKUP_MENU_LANG');

        $menuRollAiENG = config()->get('botsmanagerconf.ENG.REPLYMARKUP_MENU_MAIN');
        $menuRollAiUA = config()->get('botsmanagerconf.UA.REPLYMARKUP_MENU_MAIN');
        $menuRollAiRU = config()->get('botsmanagerconf.RU.REPLYMARKUP_MENU_MAIN');

        $menuMainENG = config()->get('botsmanagerconf.ENG.REPLYMARKUP_MENU_MAIN');
        $menuMainUA = config()->get('botsmanagerconf.UA.REPLYMARKUP_MENU_MAIN');
        $menuMainRU = config()->get('botsmanagerconf.RU.REPLYMARKUP_MENU_MAIN');


        $menuSubENG = config()->get('botsmanagerconf.ENG.REPLYMARKUP_MENU_SUB_ONE');
        $menuSubUA = config()->get('botsmanagerconf.UA.REPLYMARKUP_MENU_SUB_ONE');
        $menuSubRU = config()->get('botsmanagerconf.RU.REPLYMARKUP_MENU_SUB_ONE');


        $RU = $menuLang['keyboard'][0][0]['text'];
        $ENG = $menuLang['keyboard'][0][1]['text'];
        $UA = $menuLang['keyboard'][0][2]['text'];

        $CHK_LIMIT = [
            $menuMainENG['keyboard'][0][0]['text'],
            $menuMainUA['keyboard'][0][0]['text'],
            $menuMainRU['keyboard'][0][0]['text'],
        ];

        $SUB_MENU = [
            $menuMainENG['keyboard'][1][0]['text'],
            $menuMainUA['keyboard'][1][0]['text'],
            $menuMainRU['keyboard'][1][0]['text'],
        ];
        $ROLL_AI = [
            $menuRollAiENG['keyboard'][2][0]['text'],
            $menuRollAiUA['keyboard'][2][0]['text'],
            $menuRollAiRU['keyboard'][2][0]['text'],
        ];
/**
        $CNG_LANG = [
            $menuMainENG['keyboard'][3][0]['text'],
            $menuMainUA['keyboard'][3][0]['text'],
            $menuMainRU['keyboard'][3][0]['text'],
        ];
        */


        $BACK_MAIN = [
            $menuSubENG['keyboard'][0][0]['text'],
            $menuSubUA['keyboard'][0][0]['text'],
            $menuSubRU['keyboard'][0][0]['text'],
        ];


        /**  HOW TO SET UP ARRAY KEY
         *
         * [
         * ['text' => "\u{2B50} Famous people born on this date " . date('d F')],   <- in this case   ['keyboard'][0][0]['text']
         *
         * ],
         * [
         * ['text' => "\u{2B50} How far the Sun from the Earth in km."], <- in this case   ['keyboard'][1][0]['text']
         * ],
         * [
         * ['text' => "\u{1F519} Back to main menu"], <- in this case   ['keyboard'][2][0]['text']
         * ],
         */


        // ["\u{1F3AB} check limits left", "\u{1F3AB} перевірити залишок ліміту", "\u{1F3AB} проверить остаток лимита"],

        return match ($this->value) {


            self::NONE->value => ["none"],
            self::RU->value => [$RU],
            self::ENG->value => [$ENG],
            self::UA->value => [$UA],
            self::SUB_MENU->value => $SUB_MENU,
//            self::CNG_LANG->value => $CNG_LANG,
            self::CHK_LIMIT->value => $CHK_LIMIT,
            self::ROLL_AI->value => $ROLL_AI,
            self::BACK_MAIN->value => $BACK_MAIN,
            self::START_OVER->value => ["/start"],
        };
    }
}

/*
"\u{1F1F7}\u{1F1FA}\u{1F1EC}\u{1F1E7}\u{1f1fa}\u{1f1e6} change language",
			"\u{1F1F7}\u{1F1FA}\u{1F1EC}\u{1F1E7}\u{1f1fa}\u{1f1e6} Изменить язык",
			"\u{1F1F7}\u{1F1FA}\u{1F1EC}\u{1F1E7}\u{1f1fa}\u{1f1e6} Змінити мову", */
