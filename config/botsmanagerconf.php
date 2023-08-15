<?php
return [

    'ENG' => [
        'MENU' => [
            'chclang' => "\xF0\x9F\x91\x89Choice language of menu", 'chslang' => "\xE2\x9C\x85 You choose english as deafult",
        ],
        'NEWUSER' => [
            'wait' => "\xE2\x98\x95 Please wait for a messages of your authorization.",
            'auth' => "\u{2705} You are authorized!\n\u{2714}You can send a message to A.I.\n",
        ],
        'BOT_MODEL' => [
            'msg1' => '',
        ],
        'ERROR' => [
            'msg_validate' => "\xE2\x9A\xA0A message must be from 8 to 128 symbols.",
            'msg_def_error' => "\xE2\x9A\xA0something went wrong,try again in a while...",

        ],
        'INFO' => [
            'msg_accept' => "Message has been queued,wait for the response.",
            'msg_sent' => "The answer is being prepared, please wait...",
            'limit_have' => "\u{2714}Your limit is \u{1F3AB}",
            'limit_out' => "\u{26A0}You have reached limit of the quick answers.",
            'limit_out_delay' => "\u{231B}It might be a delay with response...",
            'back_main_menu' => "\u{2611}This is main menu",
            'ai_questions' => "Try the following questions:",
            'roll_change' => "\u{2705}Roll of \u{1F170}I change successfully!",
        ],
        'WELCOME' => "\u{2139}NFORMATION\nThank you for your help in testing this chat-bot-gpt!\n  Here you can ask questions to Artificial Intelligence from OpenAI, chatGPT.\nWithout registration and absolutely free of charge directly from the (Telegram) you can ask the AI.\n  All your messages in this chatbot remain your private and are not available to other members.\n#️⃣Menu#️⃣ of the chat in three languages (Russian, English, Ukrainian)\nbut any questions to AI can be written in your own language,\nCurrently AI supports more than 50 languages🦥\n\nChat has some limitations.\nLimits:\n✅ The number and frequency of requests to AI limited for each participant individually.\n✅ The length of the message question is no more than 128 characters.\n✅ Answers from A.I.are limited to about 700 words.\n\nRules for communicating with AI that OpenAI warns about:\n⚠️ Do not use obscene language in messages.\n⚠️ Do not use violent language or calls for any kind of violence.\n⚠️ The company reserves the right not to process your question if it violates the rules of communication with AI.\nHappy communication to all!",

        'REPLYMARKUP_MENU_MAIN' => [
            'keyboard' => [
                [
                    ['text' => "\u{1F3AB} check limits left"],
                ],
                [
                    ['text' => "\u{1F4AC} Here some questions for AI"],
                ],
                [
                    ['text' => "\u{1F4AC} Change roll of AI"],
                ],
                [
                    ['text' => "\u{1F1F7}\u{1F1FA}\u{1F1EC}\u{1F1E7}\u{1f1fa}\u{1f1e6} change language"],
                ],

            ],

            'one_time_keyboard' => true,
            'resize_keyboard' => true,
            'input_field_placeholder' => 'make your choice'

        ],
        'REPLYMARKUP_MENU_SUB_ONE' => [
            'keyboard' => [
                [
                    ['text' => "\u{1F519} Back to main menu"],
                ],
                [
                    ['text' => "\u{0031}\u{20E3} Famous people born on this date " . date('d F')],
                ],
                [
                    ['text' => "\u{0032}\u{20E3} How far is Earth from Sun in km,today " . date('d F y')],
                ],
                [
                    ['text' => "\u{0033}\u{20E3} Generate an article about the dangers of smoking."],
                ],
                [
                    ['text' => "\u{0034}\u{20E3} Generate an article on the benefits of reading books."],
                ],
                [
                    ['text' => "\u{0035}\u{20E3} What are your recommendations to live happily ever after?"],
                ],

            ],

            'one_time_keyboard' => true,
            'resize_keyboard' => true,
            'input_field_placeholder' => 'make your choice 1,2...'
        ],
        'REPLYMARKUP_MENU_INLINE' => [
            'inline_keyboard' => [

                [
                    ['text' => 'PhD', 'callback_data' => 1],
                    ['text' => 'Engineer', 'callback_data' => 2],
                    ['text' => 'Pastor John ', 'callback_data' => 3],
                ],


            ],
            'one_time_keyboard' => true,
            'resize_keyboard' => true,
        ], # end inline


    ], # end ENG

    'UA' => [
        'MENU' =>
            [
                'chclang' => "\xF0\x9F\x91\x89Оберіть мову меню", 'chslang' => "\xE2\x9C\x85 Ви обралу українську.",
            ],
        'NEWUSER' => [
            'wait' => "\xE2\x98\x95 Будь-ласка,очикуйте на повідомлення про вашу авторізвцію.",
            'auth' => "\u{2705} Ви є авторизовані!\n\u{2714}Можете відправляти повідомлення до Штучного інтелекту.\n",
        ],
        'BOT_MODEL' => [
            'msg1' => '',
        ],
        'ERROR' => [
            'msg_validate' => "\u{26A0}Повідомлення має бути не меньше 8 та не більше 128 символів.",

        ],
        'INFO' => [
            'msg_accept' => "Повідомлення принято до черги,очікуйте відповідь.",
            'msg_sent' => "Відповідь вже готується,очікуйте...",
            'limit_have' => "\u{2714}Ваш залишок ліміту \u{1F3AB}",
            'limit_out' => "\u{26A0}Ваш ліміт на швидкі запити вичерпано.",
            'limit_out_delay' => "\u{231B}Запити можуть оброблятися із затримкою...",
            'back_main_menu' => "\u{2611}Головне меню",
            'ai_questions' => "Оберіть питання зі списку:",
            'roll_change' => "\u{2705}Модель поведінки \u{1F170}I успішно змінена!",
        ],
        'WELCOME' => "\u{2139}NFORMATION\nДякую, за вашу допомогу у тестуванні бота!\nТут можна ставити запитання Штучному Інтелекту від компанії OpenAI, chatGPT.\n Без реєстрації та абсолютно безплатно прямо з (Телеграма) ви можете спілкуватися з Ш.І.\n Всі ваші повідомлення в цьому чат-боті залишаються приватними та не доступні іншим учасникам.\n#️⃣Меню#️⃣ чату трьома мовами (рус., англ., укр.) та свої питання до І.І. ви можете писати будь-якою відомою мовою світу Ш.І. розуміє понад 50 мов.🦥 \n Тестовий Чат-бот має декі обмеження.\nЛіміти:\n✅ Кількість та частота запитів до Ш.І. лімітовано для кожного учасника індивідуально.\n✅ Довжина запитів повідомлення не більше 128 символів.\n✅ Відповіді від Штучного Інтелекту обмежені до 700 слів.\nПравила спілкування зі Ш.І. про які попереджає компанія OpenAI:\n⚠️ Не використовувати нецензурну лексику у повідомленнях.\n⚠️ Не використовувати насильницьку лексику чи заклики до будь-якого виду насильства.\n⚠️ Компанія залишає за собою право не опрацьовувати ваш запит якщо він порушує правила спілкування з Ш.І.\nПриємного вам спілкування!",

        'REPLYMARKUP_MENU_MAIN' => [
            'keyboard' => [
                [
                    ['text' => "\u{1F3AB} Перевірити залишок ліміту"],
                ],
                [
                    ['text' => "\u{1F4AC} Here some questions for AI"],
                ],
                [
                    ['text' => "\u{1F4AC} Приклади готових запитань до AI"],
                ],
                [
                    ['text' => "\u{1F1F7}\u{1F1FA}\u{1F1EC}\u{1F1E7}\u{1f1fa}\u{1f1e6} Змінити мову"],
                ],

            ],
            'one_time_keyboard' => true,
            'resize_keyboard' => true,
            'input_field_placeholder' => 'Зробіть вибір'
        ],
        'REPLYMARKUP_MENU_SUB_ONE' => [
            'keyboard' => [
                [
                    ['text' => "\u{1F519} Повернутися до головного меню"],
                ],
                [
                    ['text' => "\u{0031}\u{20E3} Відомі люди народженні в цей день " . date('d F')],

                ],
                [
                    ['text' => "\u{0032}\u{20E3} Яка відстань Землі від Сонця,сьогодні " . date('d F y')],
                ],
                [
                    ['text' => "\u{0033}\u{20E3} Згенерувати статтю про шкідливість паління."],
                ],
                [
                    ['text' => "\u{0034}\u{20E3} Згенерувати статтю переваги читання книг."],
                ],
                [
                    ['text' => "\u{0035}\u{20E3} Які твої рекомендації щоби довго і щасливо жити?"],
                ],

            ],

            'one_time_keyboard' => true,
            'resize_keyboard' => true,
            'input_field_placeholder' => 'Виберіть 1,2...'
        ],
        'REPLYMARKUP_MENU_INLINE' => [
            'inline_keyboard' => [

                [
                    ['text' => 'PhD', 'callback_data' => 1],
                    ['text' => 'Engineer', 'callback_data' => 2],
                    ['text' => 'Pastor John ', 'callback_data' => 3],
                ],


            ],
        ], #end inline

    ], #end UA

    'RU' => [
        'MENU' => [
            'chclang' => "\xF0\x9F\x91\x89Выберете язык меню", 'chslang' => "\xE2\x9C\x85 Вы выбрали русский.",
        ],
        'NEWUSER' => [
            'wait' => "\xE2\x98\x95 Пожалуйста,ожидайте сообщение о вашей авторизации.",
            'auth' => "\u{2705}Вы авторизированы!\n\u{2714}Можете отправлять сообщения Искусственному интеллекту.\n",
        ],
        'BOT_MODEL' => [
            'msg1' => '',
        ],
        'ERROR' => [
            'msg_validate' => "\xE2\x9A\xA0Сообщение должно быть не меньше 8 и не больше 128 символов",

        ],
        'INFO' => [
            'msg_accept' => "Сообщение принято в очередь,ожидайте ответа.",
            'msg_sent' => "Ответ уже готовится,ожидайте...",
            'limit_have' => "\u{2714}Ваши остаток лимита \u{1F3AB}",
            'limit_out' => "\u{26A0}Ваши лимит на количество быстрых запросов, исчерпан.",
            'limit_out_delay' => "\u{231B}Сообщения будут обрабатываться с некоторой задержкой...",
            'back_main_menu' => "\u{2611}Главное меню",
            'ai_questions' => "Выберете вопрос из списка:",
            'roll_change' => "\u{2705}Модель поведінки \u{1F170}I успішно змінена!",
        ],
        'WELCOME' => "\u{2139}NFORMATION\nСпасибо, за вашу помощь в тестировании бота!\n Здесь можно задавать вопросы Искусственному Интеллекту от компании OpenAI,chatGPT.\n Без регистрации и абсолютно бесплатно прямо из (Телеграмма) вы можете общаться с ИИ.\n Все ваши сообщения в этом чат-боте остаются приватными и не доступны другим участникам.\n#️⃣Меню#️⃣ чата на трёх языках(рус.,анг.,укр.) но свои вопросы к И.И. вы можете писать на любом известном языке ИИ понимает более 50 языков 🦥\n В тестовом чат-боте есть небольшие ограничения.\nЛимиты:\n✅ Количество и частота запросов к И.И. лимитировано для каждого участника индивидуально.\n✅ Длина вопроса сообщения не более 128 символов.\n✅ Ответы от Искусственного Интеллекта ограничены до 700слов.\n Правила общения с ИИ о которые предупреждает компания OpenAI:\n⚠️ Не использовать нецензурную лексику в сообщениях.\n⚠️ Не использовать насильственную лексику или призывы к любому виду насилия.\n⚠️ Компания оставляет за собой право не обрабатывает ваш вопрос если он нарушает правила общения с И.И.\nПриятного всем общения!",

        'REPLYMARKUP_MENU_MAIN' => [
            'keyboard' => [
                [
                    ['text' => "\u{1F3AB} Проверить остаток лимита"],
                ],
                [
                    ['text' => "\u{1F4AC} Here some questions for AI"],
                ],
                [
                    ['text' => "\u{1F4AC} Примеры готовых вопросов к AI"],
                ],
                [
                    ['text' => "\u{1F1F7}\u{1F1FA}\u{1F1EC}\u{1F1E7}\u{1f1fa}\u{1f1e6} Изменить язык"],
                ],

            ],
            'one_time_keyboard' => true,
            'resize_keyboard' => true,
            'input_field_placeholder' => 'Сделайте выбор'
        ],

        'REPLYMARKUP_MENU_SUB_ONE' => [
            'keyboard' => [
                [
                    ['text' => "\u{1F519} Вернуться к главному меню"],
                ],
                [
                    ['text' => "\u{0031}\u{20E3} Известные люди рождении в этот день " . date('d F')],
                ],
                [
                    ['text' => "\u{0032}\u{20E3} Каково расстояние Земли от Солнца,сегодня " . date('d F y')],
                ],
                [
                    ['text' => "\u{0033}\u{20E3} Сгенерировать статью о вреде курения."],
                ],
                [
                    ['text' => "\u{0034}\u{20E3} Сгенерировать статью преимущества чтения книг."],
                ],
                [
                    ['text' => "\u{0035}\u{20E3} Какие твои рекомендации чтобы долго и счастливо жить?"],
                ],

            ],

            'one_time_keyboard' => true,
            'resize_keyboard' => true,
            'input_field_placeholder' => 'Выберите 1,2...'
        ],
        'REPLYMARKUP_MENU_INLINE' => [
            'inline_keyboard' => [

                [
                    ['text' => 'PhD', 'callback_data' => 1],
                    ['text' => 'Engineer', 'callback_data' => 2],
                    ['text' => 'Pastor John ', 'callback_data' => 3],
                ],

            ],
            'one_time_keyboard' => true,
            'resize_keyboard' => true,
        ], # end inline
    ], # end RUS

    'REPLYMARKUP_MENU_SECOND' => [
        'keyboard' => [
            [
                ['text' => "\u{1F1F7}\u{1F1FA}\u{1F1EC}\u{1F1E7}\u{1f1fa}\u{1f1e6} Изменить язык"],

            ],
            [
                ['text' => "\u{0039}\u{20E3}"],
                ['text' => "\u{0038}\u{20E3}"],
                ['text' => "\u{0037}\u{20E3}"],
                ['text' => "\u{0036}\u{20E3}"],
                ['text' => "\u{0035}\u{20E3}"],

            ],
            [
                ['text' => "\u{1F3AB} проверить остаток лимита"],
                ['text' => "\u{1F3AB} проверить"],
            ],

        ],
        'one_time_keyboard' => true,
        'resize_keyboard' => true,
        'input_field_placeholder' => 'Выберете язык'
    ],
    'REPLYMARKUP_MENU_INLINE' => [
        'inline_keyboard' => [

            [
                ['text' => 'PhD', 'callback_data' => 1],
                ['text' => 'Engineer', 'callback_data' => 2],
                ['text' => 'Pastor John ', 'callback_data' => 3],
            ],

        ],
        'one_time_keyboard' => true,
        'resize_keyboard' => true,
    ], # end inline


    'REPLYMARKUP_MENU_LANG' => [
        'keyboard' => [
            [
                ['text' => "\u{1F1F7}\u{1F1FA}RU"],
                ['text' => "\u{1F1EC}\u{1F1E7}ENG"],
                ['text' => "\u{1f1fa}\u{1f1e6}UA"],
            ],
        ],
        'one_time_keyboard' => true,
        'resize_keyboard' => true,
        'input_field_placeholder' => "make your choice"
    ],

    'REPLYMARKUP_MENU_RM' => [
        'remove_keyboard' => true
    ],

]; # END

/*
'REPLYMARKUP_MENU_LANG' => [
		'keyboard' => [
			[
				['text' => "RU \u{1F1F7}\u{1F1FA}"],
			],
			[
				['text' => "ENG \u{1F1FA}\u{1F1F8}"],
			],
			[
				['text' => "UA \u{1f1fa}\u{1f1e6}"],
			],
✔

*/
