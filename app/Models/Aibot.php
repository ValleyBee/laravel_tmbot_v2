<?php

namespace App\Models;


use App\Http\Controllers\Aibots;
use App\Http\Controllers\Botusers as BotUsersController;
use App\Models\Botuser as BotUserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI as OpenAIFacades;
use Illuminate\Support\Facades\Storage;

//use OpenAI as OpenAIClientBot;
use Illuminate\Support\Facades\Validator;
use App\Enums\Users\UsersMenu;
use App\Enums\Users\Status as UsersStatus;
use App\Enums\Messages\Status as MessageStatus;
use App\Models\Botmessages as BotMessageModel;

use OpenAI;
use OpenAI\Exceptions\TransporterException as OpenAiTransporterException;
use OpenAI\Exceptions\ErrorException as OpenAiErrorException;
use stdClass;


class Aibot extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected ?OpenAIFacades $openaiclientbot = null;
    protected ?Aibot $aiBot = null;
    protected ?BotMessageModel $botMessageModel = null;
    protected ?BotUsersController $botUsersController = null;
    protected ?BotUserModel $botUserModel = null;
    protected array $NODELAY = [
        'model' => 'gpt-3.5-turbo',
        'temperature' => 0.1,
        'max_tokens' => 1000,
        'user' => '',
        'n' => 1,
        'stop' => 'None',
        //'prompt' => 'Say this is a test',
        'messages' => [
            [
                "role" => 'system', 'content' => 'you are physicist with PhD'
            ],
            [
                "role" => "user", "content" => "Famous people born on August"],
        ],
    ];

    public array $DELAY = [
        'model' => 'gpt-3.5-turbo',
        'temperature' => 0.1,
        'max_tokens' => 2000,
        'user' => '',
        'n' => 1,
        'stop' => 'None',
        //'prompt' => 'Say this is a test',
        'messages' => [
            [
                "role" => 'system', 'content' => 'you are physicist with PhD.'
            ],
            [
                "role" => "user", "content" => "empty"],
        ],
    ];

    /**
     * [
     * ['text' => 'Doctor of Philosophy in Psychology', 'callback_data' => 1],
     * ],
     * [
     * ['text' => 'Master of Science in Engineering', 'callback_data' => 2],
     * ],
     * [
     * ['text' => 'Doctor of Theology in the Christian religion', 'callback_data' => 3],
     * ],
     */


// protected string $base_uri = 'https://api.openai.com/v1/chat/completions';
// protected string $message = '';
//    protected string $roleAI = '';
//    protected string $roleMessage = '';
//    public array $answerFrom;


    public static function runner(MessageStatus $account, int $numbers_loop)
    {
        Log::channel('stderr')->info("Aibot runner started");
//        echo " START " . time() . "\n";
        for ($i = 0; $i <= $numbers_loop; $i++) {
            ${'instanceName' . $account->name} = new AiBot();
            (object)$stdClassMsg = ${'instanceName' . $account->name}->getQuestionAi_setStatusBusy(${'instanceName' . $account->name}, $account);

            if ($stdClassMsg !== null) {
                ${'instanceName' . $account->name}->clientAiApi(${'instanceName' . $account->name}, $account->name, $stdClassMsg);
            }
            usleep(2 * 5000); # 2 * 1000 two miliseconds:
        }
//        echo " FINISH " . time() . "\n";
        Log::channel('stderr')->info("Aibot runner finished");
    }

    public function clientAiApi(Aibot $instanceName, $account, stdClass $stdClassMsg): void
    {
        Log::info("clientAiApi started");
        Log::channel('stderr')->info("clientAiApi started");

        if ($this->botMessageModel === null) {
            $this->botMessageModel = app('botmessage');
        }
        if ($this->botUsersController === null) {
            $this->botUsersController = app('botuserscontroller');
        }
        if ($this->botUserModel == null) {

            $this->botUserModel = app('botuser');
//                 $this->botUserModel = resolve(BotUserModel::class);
        }
//        if ($this->aiBot === null) {
//            $this->aiBot = app('aibot');
//        }

//        (object)$stdClassMsg = self::getQuestionAi_setStatusBusy();


        ${'client' . $account} = null;
        (array)$modelData = $this->{$account} ?? $this->$DELAY;

        // $response = $this->openaiclientbot->models()->list();
        // dd($response);

        // $modelData = $this->factory($modelName);

        // $modelData->data['messages'][0] = [
        // 	"role" => $this->roleAI, 'content' => $this->roleMessage
        // ];


        $updateClientData = function (array $param, string $systemRole) use (&$modelData, $stdClassMsg): array {
            $modelData['messages'][0] = [
                "role" => "system", 'content' => $systemRole,
            ];
            $modelData['messages'][1] = [
                "role" => "assistant", 'content' => $stdClassMsg->reply_from_ai ?? ''
            ];
            $modelData['messages'][2] = [
                "role" => "user", 'content' =>  date('d F y')." is the date now,my the question is: ".$stdClassMsg->content
            ];
            $modelData['user'] = $stdClassMsg->botuser_id;
            foreach ($param as $key => $value) {
                $modelData[$key] = $value;
            }
            return $modelData;
        };

        (object)$stdClassUser = $this->botUserModel->getUser($stdClassMsg->user_id);

        switch (MessageStatus::cases()[$stdClassMsg->status_msg ?? 0]->name) {
            case ("DELAY"):
//                ${'class_aitbot' . $stdClassMsg->botuser_id}
//                ${'client' . $account} = OpenAI::client(config()->get('openai.payed_response.api_key'), config()->get('openai.payed_response.organization'));
                ${'client' . $account} = OpenAI::client(config()->get('openai.free_response.api_key'), config()->get('openai.free_response.organization'));
                $systemRole = config()->get('botsmanagerconf.' . 'ENG' . '.REPLYMARKUP_MENU_INLINE' . '.inline_keyboard'); //    //UsersMenu::cases()[$stdClassUser->lang]->name
                $updateClientData(
                    [
                        'max_tokens' => 2000,
                    ],
                    'You are an assistant that speaks like ' . $systemRole[$stdClassUser->model_type][0]['text'],
                );

                Storage::append('freemodel_last_session.log', date("d/m/Y H:i:s"));
                Log::alert('freemodel_last_session');
                Log::info('Make config for DELAY question to AI, by -> MessageStatus::cases');


                /*session deleted. if you try using this you've got an error*/

                //                dd($modelData);
                /*
                $this->openaiclientbot = $client::factory()
                    ->withBaseUri('https://api.openai.com/v1/chat/completions')
                    ->withApiKey(config()->get('openai.free_response.api_key'))
                    ->withOrganization(config()->get('openai.free_response.organization'))
                    ->make();

    */
                break;
            case ("NODELAY"):
                ${'client' . $account} = OpenAI::client(config()->get('openai.payed_response.api_key'), config()->get('openai.payed_response.organization'));

                $systemRole = config()->get('botsmanagerconf.' . 'ENG' . '.REPLYMARKUP_MENU_INLINE' . '.inline_keyboard');
                $updateClientData(
                    [
                        'max_tokens' => 1000,
                    ],
                    'You are an assistant that speaks like ' . $systemRole[$stdClassUser->model_type][0]['text'],
                );
                Storage::append('paymodel_last_session.log', date("d/m/Y H:i:s"));
                Log::info('Make config for NODELAY question to AI, by -> MessageStatus::cases');


                /*
                $this->openaiclientbot = OpenAI::factory()
                    ->withBaseUri('https://api.openai.com/v1/chat/completions')
                    ->withApiKey(config()->get('payed_response.openai.api_key'))
                    ->withOrganization(config()->get('payed_response.openai.organization'))
                   ->make();
    */
                break;
            default:
//
                Log::alert('something went wrong switch, by -> MessageStatus::cases');

                exit();
        } #---------- end switch

        $msg_to_user = "\u{2611}ID:" . $stdClassMsg->message_id . " " .
        config()->get('botsmanagerconf.' . UsersMenu::cases()[$stdClassUser->lang]->name . '.INFO.msg_sent')
            ?? "\xE2\x9A\xA0Something went wrong,try again in a while...";
        $this->botUsersController
            ->sendMessageToUserTmbot(
                $stdClassMsg->botuser_id,
                $msg_to_user,
                null,
                null
            );
        Log::info('Send .INFO.msg_sent to TM USER, by ->  ->sendMessageToUserTmbot');

        /* OLD with replay
                (string)$previos_langConf = config()->get('botsmanagerconf.' . UsersMenu::cases()[$stdClassUser->lang]->name . '.INFO.ai_previos_conversation');
                (string)$new_langConf = config()->get('botsmanagerconf.' . UsersMenu::cases()[$stdClassUser->lang]->name . '.INFO.ai_new_question');


         *   $modelData->data['messages'][1] = [
                    "role" => "assistant", 'content' => $previos_langConf . ":" . $stdClassMsg->reply_from_ai
                ];
                $modelData->data['messages'][2] = [
                    "role" => "user", 'content' => $new_langConf . ":" . $stdClassMsg->content
                ];
         * */



        echo $stdClassMsg->message_id . "\n";
        echo $stdClassMsg->content . "\n";
        echo $stdClassMsg->reply_from_ai . "\n";;
        echo "USER_ID :" . $modelData['user'] . "\n";;
//        print_r($modelData->data['messages'][0]);
        var_dump($modelData);

        /********************FAKE RESPONSE*********************/
        // $client = ClientFake::fake([
        // 	CreateResponse::fake([
        // 		'choices' => [
        // 			[
        // 				'text' => 'awesome!',
        // 			],
        // 		],
        // 	]),
        // ]);

        // $completion = ClientFake::completions()->create([
        // 	'model' => 'text-davinci-003',
        // 	'prompt' => 'Say this is a test ',
        // ]);

        // dd($completion['choices'][0]['text'])->toBe('awesome!');


        // $response = $this->openaiclientbot->models()->retrieve('gpt-3.5-turbo-16k');


        /* RESPONSE
    array:6 [▼ // app/Models/AibotClient.php:97
  "id" => "chatcmpl-7SU3Zor8ikJ6Y6iH3BJo7D9TAV6d1"
  "object" => "chat.completion"
  "created" => 1687023077
  "model" => "gpt-3.5-turbo-16k-0613"
  "choices" => array:1 [▼
    0 => array:3 [▼
      "index" => 0
      "message" => array:2 [▼
        "role" => "assistant"
        "content" => "I apologize, but I'm not sure what you're asking. Could you please provide more information or clarify your question?"
      ]
      "finish_reason" => "stop"
    ]
  ]
  "usage" => array:3 [▼
    "prompt_tokens" => 35
    "completion_tokens" => 24
    "total_tokens" => 59
  ]
]

*/


        // $client = $this->openaiclientbot->factory()
        // 	->withBaseUri('https://api.openai.com/v1/chat/completions')
        // 	->withApiKey('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')
        // 	->withOrganization('org-LpihhZGSKX3jVEKwThKnYorH')
        // 	->make();

        /* How to make another client
        $client = OpenAI::client(
            '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',
            'org-ZbKTPhbh6eqDU5w5vcESFyVl'
        );
        $request = $client->chat()->create($modelData->data);

*/


//			$request = $this->openaiclientbot->chat()->create($modelData->data);
        try {
            $response = ${'client' . $account}->chat()->create($modelData);
            Log::info('RESPONSE FROM OPENAI OK, by ->  client -> chat ');
            echo "RESPONSE FROM OPENAI OK";
        } catch (OpenAiTransporterException $e) {
            echo "OpenAiTransporterException " . $e->getMessage();
//            exit();
        } catch (OpenAiErrorException $e2) {
            echo "OpenAiErrorException " . $e2->getMessage();
//            exit();
        }
        $responseFields = $response->toArray();

        Storage::append('myapp.log', date('H:i:s') . $responseFields["choices"][0]["message"]["content"]);


        self::updateWithReply($instanceName, $stdClassMsg, $responseFields);

        //        return $response->toArray();
        Log::channel('stderr')->info("clientAiApi finished");
        Log::info("clientAiApi finished");
        Log::notice(print_r("memory_usage_Aibot = " . memory_get_usage()));
    } # END Client


    public function getQuestionAi_setStatusBusy(AiBot $instanceName, MessageStatus $status): stdClass|null
    {
        $result = null;
//        echo "transactionLevel " . DB::connection(DB::getDefaultConnection())->transactionLevel() . "\n";


        if (DB::connection(DB::getDefaultConnection())->transactionLevel() == 0) {
            DB::beginTransaction();
        }

        try {
            $latest = $instanceName->latest('created_at')->where('status_msg', $status->value)->sharedLock()->first();
            if ($latest !== null) {
//				echo "setMsgStatusOnBusy";
//                $updateStatus = $this->aiBot->find($latest->id);
                (object)$result = (object)$latest->toArray();
                //$latest->status_msg = MessageStatus::BUSY;
                $latest->update();

            }
//            echo "transactionLevel " . DB::connection(DB::getDefaultConnection())->transactionLevel() . "\n";
            DB::commit();
            return $result;
//            if (DB::connection(DB::getDefaultConnection())->transactionLevel() !== 0) {
//                            }  // else, leave commit to parent transaction
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }

    }


    public function getQuestionAi_old(): stdClass|null
    {
        $latest = null;
        if ($this->aiBot === null) {
            $this->aiBot = app('aibot');
        }
        try {
            $latest = DB::transaction(function () {
                $latest = $this->aiBot->latest('created_at')->lockForUpdate()->first();
//                $latest = $this->aiBot->where('status_msg', MessageStatus::VIOLATION)->lockForUpdate()->get();

                if ($latest !== null) {
//				echo "setMsgStatusOnBusy";
//                    $this->setStatusQuestionAi($latest->id, MessageStatus::BUSY);
                    (object)$latest = (object)$latest->toArray();
                }
                return $latest;
            });

        } catch (QueryException $e) {
            echo($e);
        }
        return $latest;
    }


    public function deleteQuestionAi(int $id): void
    {
        try {
            $this->find($id)->delete();
//            $updateStatus->delete();
        } catch (QueryException $e) {
            echo($e);
        }

    }

    public function setStatusQuestionAi(int $id, MessageStatus $MessageStatus)
    {
        if ($this->aiBot === null) {
            $this->aiBot = app('aibot');
        }
        try {
            DB::transaction(function () use ($id, $MessageStatus) {
                $updateStatus = $this->aiBot->lockForUpdate()->find($id);
                $updateStatus->status_msg = $MessageStatus->value;
                $updateStatus->update();
            });
        } catch (QueryException $e) {
            echo($e);
        }

    }


    public function updateWithReply(Aibot $instanceName, stdClass $stdClassMsg, array $responseFields)
    {
        if ($this->botMessageModel === null) {
            $this->botMessageModel = app('botmessage');
        }

        try {
            DB::transaction(function () use ($instanceName, $stdClassMsg, $responseFields) {
                $updatebyReplay = $this->botMessageModel->where('message_id', $stdClassMsg->message_id)->first();
                $updatebyReplay->reply_from_ai = $responseFields["choices"][0]["message"]["content"];
                $updatebyReplay->status_msg = MessageStatus::REPLY;
                $updatebyReplay->update();
                $deleteDone = $instanceName->where('message_id', $stdClassMsg->message_id)->first();
                $deleteDone->delete();
            });

        } catch (QueryException $e) {
            echo $e;
        }
//        return $result->id;
    } // end of store

    public function storeQuestionAi(stdClass $stdClassMsg)
    {
        # IN DEV MODE
        var_dump($stdClassMsg);

        $createFields = array();
        if ($this->aiBot === null) {
            $this->aiBot = app('aibot');
        }

        try {
            $createFields['user_id'] = $stdClassMsg->user_id;
            $createFields['botuser_id'] = $stdClassMsg->botuser_id;
            $createFields['update_id'] = $stdClassMsg->update_id;
            $createFields['message_id'] = $stdClassMsg->message_id;
            $createFields['content'] = $stdClassMsg->content;
            $createFields['reply_from_ai'] = $stdClassMsg->reply_from_ai;
            $createFields['status_msg'] = $stdClassMsg->status_msg;

            $this->create($createFields);

            echo date("d/m/Y H:i:s") . " " . "add new message ID:  $stdClassMsg->message_id \n";

        } catch (QueryException $e) {
            echo $e;
        }
//        return $result->id;
    } // end of store


    public function translateAudio()
    {
        if ($this->openaiclientbot === null) {
            $this->openaiclientbot = app('aiclientbot');
        }

        $this->openaiclientbot = OpenAI::client(config()->get('openai.payed_response.api_key'), config()->get('openai.payed_response.organization'));

        $response = $this->openaiclientbot->audio()->translate([
            'model' => 'whisper-1',
            'file' => fopen('../storage/app/german.mp3', 'r'),
            'response_format' => 'verbose_json',
            'language' => 'en',

        ]);

        $response->task; // 'translate'
        $response->language; // 'english'
        $response->duration; // 2.95
        $response->text; // 'Hello, how are you?'


        foreach ($response->segments as $segment) {
            $segment->index; // 0
            $segment->seek; // 0
            $segment->start; // 0.0
            $segment->end; // 4.0
            $segment->text; // 'Hello, how are you?'
            $segment->tokens; // [50364, 2425, 11, 577, 366, 291, 30, 50564]
            $segment->temperature; // 0.0
            $segment->avgLogprob; // -0.45045216878255206
            $segment->compressionRatio; // 0.7037037037037037
            $segment->noSpeechProb; // 0.1076972484588623
            $segment->transient; // false
        }

        $response->toArray(); // ['task' => 'translate', ...]

    }


    public function createImage()
    {
        if ($this->openaiclientbot === null) {
            $this->openaiclientbot = app('aiclientbot');
        }
        $this->openaiclientbot = OpenAI::client(config()->get('openai.payed_response.api_key'), config()->get('openai.payed_response.organization'));

        $response = $this->openaiclientbot->images()->create([
            'prompt' => 'слониха кушает',
            'n' => 1,
            'size' => '256x256',
            'response_format' => 'url',
        ]);

        $response->created; // 1589478378

        foreach ($response->data as $data) {
            $data->url; // 'https://oaidalleapiprodscus.blob.core.windows.net/private/...'
            $data->b64_json; // null
        }

        dd($response->toArray()); // ['created' => 1589478378, data => ['url' => 'https://oaidalleapiprodscus...', ...]]
    }


    public function createVariationImage()
    {
        if ($this->openaiclientbot === null) {
            $this->openaiclientbot = app('aiclientbot');
        }
        $this->openaiclientbot = OpenAI::client(config()->get('openai.payed_response.api_key'), config()->get('openai.payed_response.organization'));
        $response = $this->openaiclientbot->images()->variation([
            'image' => fopen('../storage/app/image_edit_original.png', 'r'),
            'n' => 1,
            'size' => '256x256',
            'response_format' => 'url',
        ]);

        $response->created; // 1589478378

        foreach ($response->data as $data) {
            $data->url; // 'https://oaidalleapiprodscus.blob.core.windows.net/private/...'
            $data->b64_json; // null
        }

        dd($response->toArray()); // ['created' => 1589478378, data => ['url' => 'https://oaidalleapiprodscus...', ...]]
    }

    public function getModelOne()
    {

        return [
            'model' => 'gpt-3.5-turbo-16k',
            'temperature' => 0.1,
            'max_tokens' => 10000,
            'user' => '',
            'n' => 1,
            'stop' => '[" Human:", " AI:"]',
            //'prompt' => 'Say this is a test',
            'messages' => [
                [
                    "role" => 'assistant', 'content' => 'replay'
                ],
                [
                    "role" => "user", 'content' => ''
                ],
            ],

        ];
    }


    public function getModelTwo()
    {
        return [
            'model' => 'gpt-3.5-turbo',
            'temperature' => 0.2,
            'max_tokens' => 500,
            'user' => '',
            'n' => 1,
            'stop' => 'None',
            //'prompt' => 'Say this is a test',
            'messages' => [
                [
                    "role" => 'assistant', 'content' => 'replay'
                ],
                [
                    "role" => "user", 'content' => ''
                ],
            ],
        ];
    }

    public function prepareAnswerMsgWithValuation(array $validateUserMessage): array
    {
        $answerFromAI['choices'][0]['message']['content'] =
            $validateUserMessage['warningMessage'] . $validateUserMessage['category'];
        return $answerFromAI;
    }

    public static function validateUserMessageLength(string $userMessage): bool
    {
        $validator = Validator::make(
            array('content' => $userMessage),
            array('content' => 'required|min:8|max:128')
        );

        return $validator->fails();

        // $msgLength = mb_strlen($userMessage);
        // if ($msgLength <= 8 or $msgLength >= 100) {
        // 	return true;
        // }
        // return false;

    }


    public function validateUserMessageAiRules(string $userMessage): array
    {
        (array)$responseResult = [];
        (array)$response = [];
        if ($this->openaiclientbot === null) {
            $this->openaiclientbot = app('aiclientbot');
        }

        try {
            $response = $this->openaiclientbot->moderations()->create([
                'model' => 'text-moderation-latest',
                'input' => $userMessage,
            ]);
        } catch (OpenAiTransporterException $e) {

            echo "OpenAiTransporterException " . $e->getMessage();
            exit();
        }


        foreach ($response->results as $result) {
            $result->flagged; // true

            foreach ($result->categories as $category) {
                if ($category->violated) // true
                {
                    echo $category->category->value; // 'violence'
                    $responseResult['category'] = $category->category->value;
                    $responseResult['warningMessage'] = "Извините,ваше сообщение нарушает правило общения! - Sorry, your last message is violating the conversation regulation in category of : ";

                    // echo $category->violated; // true
                    // echo 	$category->score; // 0.97431367635727
                }
            }
        }

        return $responseResult;
    }




    // public function &factory(string $className)
    // {

    // 	$className = "App\Models\\" . $className;

    // 	if ($this->aiBot === null) {
    // 		$class  = new \ReflectionClass($className);
    // 		$this->aiBot = $class->newInstance();
    // 	}

    // 	return $this->aiBot;
    // }


}


