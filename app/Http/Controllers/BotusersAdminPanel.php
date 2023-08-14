<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Botuser as BotUserModel;
use App\Models\NewUsers;
use App\Models\Message;
use App\Models\Botmessages as BotMessageModel;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;

// use Telegram\Bot\Api as TelegramApi;
use Telegram\Bot\FileUpload\InputFile;
use Illuminate\Support\Str;
use Telegram\Bot\BotManager;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Exceptions\TelegramResponseException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Database\QueryException;
use App\Enums\Messages\Status as MessageStatus;
use App\Enums\Users\Status as UsersStatus;

use App\Enums\Users\UsersMenu;
use stdClass;

// use Illuminate\Http\Request;

class BotusersAdminPanel extends Botusers
{

    protected ?BotUserModel $botUserModel = null;
    protected ?UserProfile $userProfile = null;
    protected ?NewUsers $newUsers = null;
    protected ?stdClass $stdClassMsg = null;
    protected ?stdClass $stdClassUser = null;
    protected ?Botusers $botuserscontroller = null;
    protected ?BotManager $telegram = null;

    // protected ?Message $messageModel = null;
    protected ?BotMessageModel $botMessageModel = null;


    public string $tmBotModel = '';
    // public int $message_id = 0;
    // public int $update_id = 0;
    // public int $botuser_id = 0;
    // public string $first_name;
    // public string $last_name;
    // public string $content;
    // public int $status;




    public function userAllMessages(int $id)
    {
        $msg = [];

        if ($this->botUserModel === null) {
            // $this->botUserModel = resolve(Botuser::class);
            $this->botUserModel = app('botuser');
        }
        try {
            $botuser = $this->botUserModel->findOrFail($id);
            $msg = ($botuser->messages())->orderBy('created_at', 'desc')->get();
        } catch (QueryException $e) {
            echo($e);
        }


        return view('show-users-msg', compact('msg', 'botuser'));
    }


    public function showAllUsers()
    {
        (object)$dataUsers= null;

        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
        }

        try {
            $dataUsers = $this->botUserModel->select('id', 'botuser_id', 'created_at', 'status_usr')->get();

        } catch (QueryException $e) {
            echo($e);
        }

        if ($dataUsers == null) {

//            (object)$users = new stdClass();
            $allusers[] = new stdClass();
            $dataUsers = [];
//            $users->id = 0;
//            $users->botuser_id = 0;
//            $users->created_at = 0;
//            $users->status_usr= 0;
//            $dataUsers[] = $users;

        } else {
            $dataUsers->toArray();
            foreach ($dataUsers as $user) {
                $allusers[] = (object)$user;
            }
        }


        return view('all-users', compact('allusers'));
    }

    public function editUser(int $id)
    {
        (object)$user = null;
        (object)$userMsg = null;
        if ($this->botUserModel === null) {
            // $this->botUserModel = resolve(Botuser::class);
            $this->botUserModel = app('botuser');
        }

        try {
            $user = $this->botUserModel->select('id', 'botuser_id', 'created_at', 'status_usr', 'model_type', 'limit_req_num', 'lang')->findOrFail($id);
            // dd($user->messages());

            $userMsg = ($user->messages())->orderBy('created_at', 'desc')->first();

            // dd($userMsg);
        } catch (QueryException $e) {
            echo($e);
        }
        if ($user) {
            (object)$user = (object)$user->toArray();
            $statuses = UsersStatus::toAssociativeArray();
        } else {
            echo("USER NOT FOUND\n");
            return abort(404);
        }
        if ($userMsg == null) {
            $userMsg = new stdClass();
            $userMsg->first_name = null;
            $userMsg->last_name = null;
            $userMsg->content = null;
            $userMsg->reply_from_ai = null;
            $userMsg->created_at = null;
        }

        // $statuses = UsersStatus::cases();
        // (object)$statuses = (object)$statuses;

        return view('edit-users', compact('user', 'userMsg', 'statuses'));
    }

    public function editMessage(int $id)
    {
        (object)$user = null;

        if ($this->botMessageModel === null) {
            $this->botMessageModel = app('botmessage');
        }
        $userMsg = $this->botMessageModel->getMsgById($id);
        // dd($userMsg);

        // (object)$userMsg = (object)$userMsg->toArray();
        $statuses = MessageStatus::toAssociativeArray();

        // $statuses = UsersStatus::cases();
        (object)$statuses = (object)$statuses;


        return view('edit-msg', compact('userMsg', 'statuses'));
    }

    public function updateMsg(Request $request)
    {
        if ($this->botMessageModel === null) {
            $this->botMessageModel = app('botmessage');
        }
        (array)$dataMsg = $request->only(['id', 'status']);
        try {
            $userMsg = $this->botMessageModel->find($dataMsg['id']);
            if (is_null($userMsg)) {
                echo("MSG NOT FOUND\n");
                return abort(404);
            }
            $userMsg->status_msg = $dataMsg['status'];
            $userMsg->update();
        } catch (QueryException $e) {
            echo $e;
        }
        // dd($request->method());
        // dd($request->submit);
        return redirect()->route('message.edit', $userMsg->id);
    }

    public function deleteMsg(int $id)
    {
        if ($this->botMessageModel === null) {
            $this->botMessageModel = app('botmessage');
        }

        try {
            $userMsg = $this->botMessageModel->find($id);
            if (is_null($userMsg)) {
                echo("MSG NOT FOUND error message \n");
                return abort(404);
            }

            $userMsg->delete();
        } catch (QueryException $e) {
            echo $e;
        }
        // dd($request->method());
        // dd($request->submit);

        return redirect()->route('userallmsg.messages', $userMsg->user_id);
    }


    public function updateUser(Request $request)
    {

        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
            // $this->botUserModel = resolve(Botuser::class);
        }

        (array)$dataUser = $request->only(['id', 'botuser_id', 'status', 'limit_req_num']);

        try {
            $user = $this->botUserModel->find($dataUser['id']);
            if (is_null($user)) {
                echo "<font color='red'>" . "USER NOT FOUND error message \n" . "</font>";
                return abort(404);
            }
            $user->status_usr = $dataUser['status'];
            $user->limit_req_num = $dataUser['limit_req_num'];
            $user->update();
        } catch (QueryException $e) {
            echo $e;
        };

        // if (($dataUser['limit_req_num'] > 0) and (UsersStatus::cases()[$dataUser['status']]->name == "AUTHORIZED")) {
        // 	echo "<font color='green'>" . "USER AUTHORIZED" . "</font>";
        // 	exit();
        // }
        /*
        $request->validate([
            'content' => 'required|min:8|max:512',
            'title' => 'required|min:3',
            'category_id' => 'required'
        ]);


*/

        /*    (array)$args = $request->all();
            $post = new Post();
            $post->title = $args['title'];
            $post->content = $args['content'];
            $post->save();
    */

        return redirect()->route('user.edit', $user->id);
    }

    public function photoToUserTmbot(array $userLastMessage, array $answer): bool
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

        $userLastMessage['botuser_id'] = '909149522'; //909149522
        $userLastMessage['message_id'] = '';
        $img = curl_file_create('https://unsplash.com/photos/cPF2nlWcMY4', 'image/png', 'test_name');
        $photo = 'tt.png';


        try {

            $this->telegram->bot($tmBotModel)->sendPhoto([
                'chat_id' => $userLastMessage['botuser_id'],
                'reply_to_message_id' => $userLastMessage['message_id'],
                'photo' => InputFile::contents(file_get_contents($photo), 'testname'),
                // , 'str_random(10)' . '.' . $photo->getClientOriginalExtension()),
                'caption' => 'no water',
                'allow_sending_without_reply' => true
            ]);
        } catch (ConnectException|TelegramResponseException|TelegramSDKException $e) {
            echo "Telegram Exception : " . $e->getCode() . " : " . $e->getMessage();
            exit();
        }

        return true;
    }

    public function sendMessageAuth(Request $request)
    {
        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
            // $this->botUserModel = resolve(Botuser::class);
        }
        (array)$requestData = $request->only(['id', 'status', 'limit_req_num']);
        try {
            (object)$user = $this->botUserModel->find($requestData['id']);
            if (is_null($user)) {
                echo date("d/m/Y H:i:s") . "(sendMessageAuth) user not found \n";
                return abort(404);
            }
        } catch (QueryException $e) {
            echo $e;
        };
        // (object)$user = (object)$user->toArray();
        if (($requestData['limit_req_num'] > 0) and (UsersStatus::cases()[$requestData['status']]->name == "AUTHORIZED")) {
            (string)$msg_to_user = config()->get(
                'botsmanagerconf.' . UsersMenu::cases()[$user->lang]->name . '.NEWUSER.auth'
            );
            $msg_to_user .= config()->get('botsmanagerconf.' . UsersMenu::cases()[$user->lang]->name . '.INFO.limit_have') . " " . $requestData['limit_req_num']
                ?? "error msg_to_user";
            (string)$welcome_msg_to_user = config()->get('botsmanagerconf.' . UsersMenu::cases()[$user->lang]->name . '.WELCOME') ?? "error welcome_msg_to_user";
            // dd($welcome_msg_to_user);

            parent::sendMessageToUserTmbot(
                $user->botuser_id,
                $msg_to_user,
                null,
                null
            );
            parent::sendMessageToUserTmbot(
                $user->botuser_id,
                $welcome_msg_to_user,
                null,
                null
            );
        }
        // exit();

        /*
        $request->validate([
            'content' => 'required|min:8|max:512',
            'title' => 'required|min:3',
            'category_id' => 'required'
        ]);
*/

        /*    (array)$args = $request->all();
            $post = new Post();
            $post->title = $args['title'];
            $post->content = $args['content'];
            $post->save();
    */

        return redirect()->route('user.edit', $user->id);
    }

    public function sendMenu(Request $request)
    {
        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
            // $this->botUserModel = resolve(Botuser::class);
        }
        (array)$requestData = $request->only(['id', 'status']);
        try {
            (object)$user = $this->botUserModel->find($requestData['id']);
            if (is_null($user)) {
                echo date("d/m/Y H:i:s") . "(sendMenu) user not found \n";
                return abort(404);
            }
        } catch (QueryException $e) {
            echo $e;
        };
        // (object)$user = (object)$user->toArray();

        (string)$msg_to_user = config()->get(
            'botsmanagerconf.' . UsersMenu::cases()[$user->lang]->name . '.NEWUSER.auth');

//        (array) $menu =config()->get(
//            'botsmanagerconf.' . UsersMenu::cases()[$user->lang]->name . '.REPLYMARKUP_MENU_SECOND');

        (array) $menu =config()->get(
            'botsmanagerconf.' . 'REPLYMARKUP_MENU_SECOND');

//        dd($menu);
        parent::sendMessageToUserTmbot(
            $user->botuser_id,
            'new menu',
            null,
            $menu
        );


        // exit();

        /*
        $request->validate([
            'content' => 'required|min:8|max:512',
            'title' => 'required|min:3',
            'category_id' => 'required'
        ]);
*/

        /*    (array)$args = $request->all();
            $post = new Post();
            $post->title = $args['title'];
            $post->content = $args['content'];
            $post->save();
    */

        return redirect()->route('user.edit', $user->id);
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

            'chat_id' => '-1001776779122',
            'photo' => InputFile::contents(file_get_contents($photo->getRealPath()), Str::random(10) . '.' . $photo->getClientOriginalExtension())
        ]);

        return redirect()->back();
    }
}
