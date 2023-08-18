<?php

namespace App\Http\Controllers;


use App\Enums\Messages\Status;
use App\Enums\Messages\Status as MessageStatus;

use Illuminate\Http\Request;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Http;
use Telegram\Bot\Exceptions\TelegramSDKException;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Completions\CreateResponse;
use OpenAI\Exceptions\ErrorException as OpenAiExceptions;
use App\Models\Aibot;
class Aibots extends Controller
{



	public string $message = '';
	public string $roleAI = 'system';
	public string $roleMessage = 'your are engineer';
	public string $reply_from_ai = '';
	//'This is previous conversation, your answer was: ';

	public Http $request2;
	public $request;
	//
    protected ?Aibot $aiBot = null;


	/**
	 * Display a listing of the resource.
	 */

public function start(){

            if ($this->aiBot === null) {
            $this->aiBot = app('aibot');
        }
    Aibot::runner(MessageStatus::NODELAY);


}

    public function start_two(){

        if ($this->aiBot === null) {
            $this->aiBot = app('aibot');
        }
        Aibot::runner(MessageStatus::NODELAY);

    }


	public function clientAibot_old(array $dataToSend, string $msgPrevousReply): string
	{
		echo $msgPrevousReply;


		// dd($dataToSend);
		// $yourApiKey = getenv('OPENAI_API_KEY');
		// $yourApiKey = config('openai');
		// dd($yourApiKey);


		$yourApiKey = config('openai.api_key');
		// ($yourApiKey);
		// $client = OpenAI::client($yourApiKey);

		// $result = $client->completions()->create([
		// 	'model' => 'text-davinci-003',
		// 	'prompt' => 'PHP is',
		// ]);

		// echo $result['choices'][0]['text']; // an open-source, widely-used, server-side scripting language.

		// $request = OpenAI::models()->list();

		$request = OpenAI::chat()->create([
			'model' => 'gpt-3.5-turbo',
			'temperature' => 0.4,
			'max_tokens' => 1000,
			'user' => $dataToSend['botuser_id'],
			'n' => 1,
			'stop' => 'None',
			//'prompt' => 'Say this is a test',
			'messages' => [
				[
					"role" => $this->roleAI, 'content' => $this->roleMessage
				],
				[
					"role" => "user", 'content' => "This is previous conversation, your answer was: " . $msgPrevousReply . "This is new question: " . $dataToSend['content']
				],
			],
		]);



		$response = $request->toArray();

		// } catch (OpenAiExceptions $e) {
		// 	echo $e;
		// }



		// dd($result['choices'][0]['text']); // an open-source, widely-used, server-side scripting language.

		/* ----------------------------- */
		// $request2 = Http::withHeaders(self::CLIENT);


		// $response =	$request2->post($this->base_uri, [
		// 	'model' => 'gpt-3.5-turbo',
		// 	'temperature' => 0.4,
		// 	'max_tokens' => 1000,
		// 	'user' => $dataToSend['botuser_id'],

		// 	'messages' => [
		// 		[
		// 			"role" => $this->roleAI, 'content' => $this->roleMessage
		// 		],
		// 		[
		// 			"role" => "user", 'content' => "This is previous conversation, your answer was: " . $msgPrevousReply . "This is new question: " . $dataToSend['content']
		// 		],
		// 	],
		// ]);






		// $response = $request->json();



		echo "<br>";
		if (isset($response['choices'][0]['message']['content'])) {
			ob_start();
			echo "\e[1;37;44mAI CONNECT SUCCESS AND SEND ANSWER :\e[0m" . $response['choices'][0]['message']['content'];
			error_log(ob_get_clean(), 4);
			// echo "<br>";
			echo $this->reply_from_ai . $response['choices'][0]['message']['content'];

			return  $response['choices'][0]['message']['content'];
		} else {

			return 'null';
		}
	}



	public function test()
	{

        if ($this->aiBot === null) {
            $this->aiBot = app('aibot');
        }
//        $this->aiBot->translateAudio();
//        $this->aiBot->createImage();
        $this->aiBot->createVariationImage();

	}



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
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		//
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
}
