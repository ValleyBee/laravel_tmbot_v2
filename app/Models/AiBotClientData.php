<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenAI\Client as OpenAIClientBot;
use App\Enums\Users\Status as UsersStatus;
use OpenAI\Laravel\Facades\OpenAI as OpenAIFacades;
use Illuminate\Support\Facades\Storage;

//use OpenAI as OpenAIClientBot;
use Illuminate\Support\Facades\Validator;
use App\Enums\Users\UsersMenu;

use OpenAI;
use OpenAI\Exceptions\TransporterException as OpenAiTransporterException;
use OpenAI\Exceptions\ErrorException as OpenAiErrorException;
use stdClass;


class AiBotClientData extends Model
{
    public function __construct(string $nameClient)
    {
        echo "THIS IS AiBotClientData";
//        $this->openaiclientbot_one = OpenAI::client(config()->get('openai.free_response.api_key'), config()->get('openai.free_response.organization'));
        $this->nameClient = $nameClient;


    }
    public static function runner_pay(){
        $i = 1;
        ${'a' . $i} = new AiBotClientData('pay');
        ${'a' . $i}->model();
        ${'b' . $i} = new AiBotClientData('pay_two');
        ${'b' . $i}->model();

}
    public static function runner_free(){
        $i = 1;
        ${'a' . $i} = new AiBotClientData('free');
        ${'a' . $i}->model();
        ${'b' . $i} = new AiBotClientData('free_two');
        ${'b' . $i}->model();

    }



//    public function __invoke()
//    {
//
//    }

    protected ?OpenAIClientBot $openaiclientbot = null;
    protected string $nameClient;

    public array $data = [
        'model' => 'gpt-3.5-turbo',
        'temperature' => 0.2,
        'max_tokens' => 100,
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

    public array $data2 = [
        'model' => 'gpt-3.5-turbo',
        'temperature' => 0.2,
        'max_tokens' => 500,
        'user' => '',
        'n' => 1,
        'stop' => 'None',
        //'prompt' => 'Say this is a test',
        'messages' => [
            [
                "role" => 'system', 'content' => 'you are physicist with PhD'
            ],
            [
                "role" => "user", "content" => "Famous people born on 04 August"],
        ],
    ];

    public array $data3 = [
        'model' => 'gpt-3.5-turbo',
        'temperature' => 0.2,
        'max_tokens' => 500,
        'user' => '',
        'n' => 1,
        'stop' => 'None',
        //'prompt' => 'Say this is a test',
        'messages' => [
            [
                "role" => 'system', 'content' => 'you are physicist with PhD'
            ],
            [
                "role" => "user", "content" => "Famous people born on 08 August"],
        ],
    ];

//    public OpenAI\Client $openaiclientbot;

//    public OpenAI\Client $openaiclientbot_two;
//    public OpenAI\Client $openaiclientbot_three;

    public  function model()
    {
        /*
                $clientFactory = OpenAI::factory()
                    ->withApiKey(config()->get('openai.free_response.api_key'))
                    ->withOrganization( config()->get('openai.free_response.organization')) // default: null
                    ->withBaseUri('openai.example.com/v1') // default: api.openai.com/v1
                    ->withHttpClient($client = new \GuzzleHttp\Client([])) // default: HTTP client found using PSR-18 HTTP Client Discovery
                    ->withHttpHeader('X-My-Header', 'foo')
                    ->withQueryParam('my-param', 'bar')
                    ->withStreamHandler(fn (RequestInterface $request): ResponseInterface => $client->send($request, [
                        'stream' => true // Allows to provide a custom stream handler for the http client.
                    ]))
                    ->make();
        */


        echo "METHOD STARTED";
        if ($this->nameClient == 'free' OR 'free_two') {
            $this->openaiclientbot = OpenAI::client(config()->get('openai.free_response.api_key'), config()->get('openai.free_response.organization'));
        }
        if ($this->nameClient == 'pay' OR "pay_two") {
            $this->openaiclientbot = OpenAI::client(config()->get('openai.payed_response.api_key'), config()->get('openai.payed_response.organization'));
        }

//        $this->openaiclientbot_three = $this->openaiclientbot_two;
        try {
            Storage::append('response_client'.$this->nameClient, date('H:i:s') . "CLIENT .$this->nameClient.STARTED");
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'storage/logs/queue.log'.$this->nameClient, date('H:i:s').'STARTED', FILE_APPEND | LOCK_EX);

            $response_one = $this->openaiclientbot->chat()->create($this->data);

            file_put_contents($_SERVER['DOCUMENT_ROOT'].'storage/logs/queue.log'.$this->nameClient, date('H:i:s').'FINISHED', FILE_APPEND | LOCK_EX);
            Storage::append('response_client'.$this->nameClient, date('H:i:s') . "CLIENT . $this->nameClient FINISHED");
//
//            Storage::append('response_client', date('H:i:s')."CLIENT TWO STARTED");
//            $response_two = $this->openaiclientbot_two->chat()->create($this->data2);
//            Storage::append('response_client', date('H:i:s')."CLIENT TWO FINISHED");
//
//            Storage::append('response_client', date('H:i:s')."CLIENT THREE STARTED");
//            $response_three = $this->openaiclientbot_three->chat()->create($this->data3);
//            Storage::append('response_client', date('H:i:s')."CLIENT THREE FINISHED");
            echo "RESPONSE FROM OPENAI OK";

        } catch (OpenAiTransporterException $e) {
            echo "OpenAiTransporterException " . $e->getMessage();
//            exit();
        } catch (OpenAiErrorException $e2) {
            echo "OpenAiErrorException " . $e2->getMessage();
//            exit();
        }
        $response_one = $response_one->toArray();
//        $response_two = $response_two->toArray();
//        $response_three = $response_three->toArray();

//        var_dump($response_three);
//        var_dump($response_two);
//        var_dump($response_one);

        Storage::append('response_client', date('H:i:s') . $response_one["choices"][0]["message"]["content"]);
//        Storage::append('response_client', date('H:i:s').$response_two["choices"][0]["message"]["content"]);
//        Storage::append('response_client', date('H:i:s').$response_three["choices"][0]["message"]["content"]);
        echo "METHOD FINISHED";
    }
    // public function __construct(string $name)
    // {
    // 	$this->name = $name;
    // }
    public static function getModel()
    {
        return static::model();
    }

    public function storeToFile(): void
    {
        for ($i = 0; $i <= 10000; $i++) {
            Storage::append('store_.one', $i . " store_one" . date('H:i:s'));
            Storage::append('store_.two', $i . ' store_two' . date('H:i:s'));
            Storage::append('store_.three', $i . ' store_three' . date('H:i:s'));
        }
    }

    use HasFactory;

    // public string $model;
    // public float  $temperature;
    // public int $max_tokens;
    // public string $user;
    // public int $n;
    // public string $stop;
    // //'prompt' => 'Say this is a test',
    // public array $messages;


    // public string $base_uri;
    // public string $message;
    // public string $roleAI;
    // public string $roleMessage;
    // public string $reply_from_ai;
    // //'This is previous conversation, your answer was: ';
    // public string $message_ans;
}

class ModelOne extends AiBotClientData
{

    protected ?OpenAIClientBot $openaiclientbot = null;
    protected array $userMessage = [
        'user_id' => '',
        'reply_from_ai' => '',
        'content' => 'hello'
    ];
    protected string $roleAI = 'system';
    protected string $roleMessage = 'your are engineer';


    public function clientAiBot(array $userMessage): array
    {
        if ($this->openaiclientbot === null) {
            $this->openaiclientbot = app('aiclientbot');
        }

        echo "This is new question: " . $userMessage['content'];
        echo "previous conversation = " . $userMessage['reply_from_ai'];

        $dataForModel = $this->model();
        $request = $this->openaiclientbot->chat()->create($dataForModel);

        $response = $request->toArray();

        dd($response);
    }


    public function model(): array
    {
        return [
            'model' => $this->model,
            'temperature' => 0.4,
            'max_tokens' => 1000,
            'user' => $this->userMessage['user_id'],
            'n' => 1,
            'stop' => 'None',
            //'prompt' => 'Say this is a test',
            'messages' => [
                [
                    "role" => $this->roleAI, 'content' => $this->roleMessage
                ],
                [
                    "role" => "user", 'content' => "This is previous conversation, your answer was: " . $this->userMessage['reply_from_ai'] . "This is new question: " . $this->userMessage['content']
                ],
            ],
        ];
    }
}
