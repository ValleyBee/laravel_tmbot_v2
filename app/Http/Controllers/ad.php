<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Botuser as BotUserModel;
use App\Models\NewUsers;
use App\Models\Message;
use App\Models\BotMessage as BotMessageModel;
use Telegram\Bot\Laravel\Facades\Telegram;
// use Telegram\Bot\Api as TelegramApi;
use Telegram\Bot\FileUpload\InputFile;
use Illuminate\Support\Str;
use Telegram\Bot\BotManager;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Exceptions\TelegramResponseException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Database\QueryException;
use App\Enums\Users\Status as UsersStatus;
use stdClass;

// use Illuminate\Http\Request;

class BotusersAdminPanel extends Controller
{
	public function userAllMessages(int $id)
	{
		$msg = [];

		if ($this->botUserModel === null) {
			// $this->botUserModel = resolve(Botuser::class);
			$this->botUserModel = app('botuser');
		}
		try {
			$botuser =	$this->botUserModel->findOrFail($id);
			$msg = ($botuser->messages())->orderBy('created_at', 'desc')->get();
		} catch (QueryException $e) {
			echo ($e);
		}


		return view('show-users', compact('msg', 'botuser'));
	}



	public function showAllUsers()
	{

		if ($this->botUserModel === null) {
			// $this->botUserModel = resolve(Botuser::class);
			$this->botUserModel = app('botuser');
		}

		try {
			$allusers =	$this->botUserModel->select('id', 'user_id', 'created_at', 'status_usr')->get()->toArray();
		} catch (QueryException $e) {
			echo ($e);
		}
		// dd($botusers);
		return view('all-users', compact('allusers'));
	}

	public function editUser(int $id)
	{
		(object)$user = null;
		if ($this->botUserModel === null) {
			// $this->botUserModel = resolve(Botuser::class);
			$this->botUserModel = app('botuser');
		}

		try {
			$user =	$this->botUserModel->select('id', 'user_id', 'created_at', 'status_usr')->findOrFail($id);
		} catch (QueryException $e) {
			echo ($e);
		}
		if ($user) {

			(object)$user = (object)$user->toArray();
			$user->first_name = '';
			$user->last_name = '';

			// dd($user);
		}
		// dd($botusers);
		return view('edit-users', compact('user'));
	}




	public function photoToUserTmbot(array $userLastMessage, array $answer = ['choices'][0]['message']['content']): bool
	{
		if ($this->botUserModel === null) {
			$this->botUserModel = app('botuser');
		}
		if ($this->telegram === null) {
			$this->telegram = app('telegram');
		}

		echo "<pre>";
		print_r($userLastMessage);
		echo "<pre>";
		print_r($answer);
		echo "</pre>";
		// exit();
		$tmBotModel = self::getModelTmBot();

		$userLastMessage['user_id'] = '909149522'; //909149522
		$userLastMessage['message_id'] = '';
		$img = curl_file_create('https://unsplash.com/photos/cPF2nlWcMY4', 'image/png', 'test_name');
		$photo = 'tt.png';


		try {

			$this->telegram->bot($tmBotModel)->sendPhoto([
				'chat_id' => $userLastMessage['user_id'],
				'reply_to_message_id' => $userLastMessage['message_id'],
				'photo' => InputFile::contents(file_get_contents($photo), 'testname'),
				// , 'str_random(10)' . '.' . $photo->getClientOriginalExtension()),
				'caption' => 'no water',
				'allow_sending_without_reply' => true
			]);
		} catch (ConnectException | TelegramResponseException | TelegramSDKException $e) {
			echo "Telegram Exception : " . $e->getCode() . " : " .  $e->getMessage();
			exit();
		}

		return true;
	}

	public function sendMessage()
	{
		return view('message');
	}
	public function sendPhoto()
	{
		return view('photo');
	}


	public function storePhoto(Request $request)
	{
		if ($this->botUserModel === null) {
			$this->botUserModel = app('botuser');
		}
		if ($this->telegram === null) {
			$this->telegram = app('telegram');
		}

		$tmBotModel = self::getModelTmBot();

		$request->validate([
			'file' => 'file|mimes:jpeg,png,gif'
		]);

		$photo = $request->file('file');


		$this->telegram->bot($tmBotModel)->sendPhoto([

			'chat_id' => '-1001923804044',
			'photo' => InputFile::contents(file_get_contents($photo->getRealPath()), Str::random(10) . '.' . $photo->getClientOriginalExtension())
		]);

		return redirect()->back();
	}
}
