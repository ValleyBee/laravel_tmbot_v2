<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\Users\Status as UsersStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use stdClass;


// use stdClass;

// use Telegram\Bot\BotManager;

class Botuser extends Model
{
    public string $test1;

    // public function __construct()
    // {

    // 	echo "Botuser model constructor ";
    // 	// $this->botUserModel = resolve(Botuser::class);
    // 	echo self::$counter++;
    // }
    use HasFactory;

    protected $guarded = [];
    protected ?Botuser $botUserModel = null;
    // protected ?Message $messageModel = null;
    // protected ?BotManager $telegram = null;

    /*-----------------
    public static $counter = 0;
    public int $message_id;
    public int $update_id;
    public int $botuser_id;
    public int $user_id;
    public string $first_name;
    public string $last_name;
    public string $content;
    public int $status;
*/
    protected $value = 0;
    public function increase()
    {
        $this->value++;

        return $this->value;
    }

    public function messages()
    {

        return $this->hasMany(Botmessages::class, 'user_id');
    }

    public function generateToken_manual(): string
    {
        $string = bin2hex(random_bytes(128));
        return substr($string, 0, 64);
    }

    public function getByToken(string $token): ?array
    {
        $res = $this->selector()->where(
            'token = :token',
            ['token' => $token]
        )->get();
        return $res[0] ?? null;
    }

    protected function sleepFloatSecs(int $secs = 30)
    {
        ob_start();
        echo("\e[97;44msleep for sec \e[0m" . $secs);
        // echo "\e[0;31;44mMerry Christmas!\e[0m\n";
        error_log(ob_get_clean(), 4);

        // flush();
        // ob_flush();

        sleep($secs);
    }


    /*
    protected function usersValidation($data)
    {

        try {
            //$user_found = Botuser::find($data['botuser_id']);
            // $user_found = Botuser::where('botuser_id',  $data['botuser_id'])->get(['id', 'botuser_id'])->toArray(); // return array[0]
            $user_found = Botuser::where('botuser_id',  $data['botuser_id'])->first();
        } catch (QueryException $e) {
            echo $e;
        }
        // dd($user_found);
        if ($user_found !== null) {
            $user_found  = $user_found->toArray();

            self::storeTmMesssages($user_found, $data);
        } else {

            self::createUser($data);

            $user_found = Botuser::where('botuser_id',  $data['botuser_id'])->first();
            $user_found  = $user_found->toArray();
            self::storeTmMesssages($user_found, $data);
        }
    }

*/


    public function responseFieldsToProperty(array $data)
    {

        if ($this->botUserModel === null) {
            // $this->botUserModel = resolve(Botuser::class);
            $this->botUserModel = app('botuser');
        }


        return $this;
    }


    public function getCountUsersWithStatus(UsersStatus $status)
    {
        $user_status_result = null;
        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
            // $this->botUserModel = resolve(Botuser::class);
        }
        try {
            $user_status_result = $this->botUserModel->select(
                'id',
                'created_at',
                'updated_at',
                'botuser_id',
                'status_usr',
                'model_type',
                'limit_req_num',
                'lang')->where('status_usr',$status->value)->get();

        } catch (QueryException $e) {
            echo $e;
        }

        if (is_null($user_status_result)) {
//            Log::info( "USER NOT FOUND getUserStatus");
//            return abort(404);
            // } else {
            // 	(object)$user_found = (object)$user_found->toArray();
            // 	echo "<pre>";
            // 	echo "user status \n";
            // 	echo "</pre>";
        }
        return $user_status_result;
    }


    public function getUserModelType(int $id): int
    {
        (object)$user_found = null;
        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
        }
        try {
            (object)$user_found = $this->botUserModel->select('model_type')->find($id);
        } catch (QueryException $e) {
            echo $e;
        }
        if (is_null($user_found)) {

            Log::info( "USER NOT FOUND getUserModelType");
            return abort(404);
            // } else {
            // 	(object)$user_found = (object)$user_found->toArray();
            // 	echo "<pre>";
            // 	echo "user model type \n";
            // 	echo "</pre>";
        }
        return $user_found->model_type;
    }

    public function getUser(int $id): stdClass
    {
        // echo ('GetUSER');
        (object)$user_found = null;
        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
        }
        try {
            (object)$user_found = $this->botUserModel->select(
                'id',
                'created_at',
                'updated_at',
                'botuser_id',
                'status_usr',
                'model_type',
                'limit_req_num',
                'lang'
            )->find($id);
        } catch (QueryException $e) {
            echo $e;
        }

        if (is_null($user_found)) {
            Log::info( "USER NOT FOUND getUser");
            return abort(404);
            // 	return $user_found;
            // }

            // echo "<pre>";
            // echo "user found \n";
            // echo "</pre>";
        }
        (object)$user_found = (object)$user_found->toArray();
        return $user_found;
    }

    public function findByBotuser_id(int $botuser_id): stdClass|null
    {
        (object)$user_found = null;
        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
        }
        try {
            (object)$user_found = $this->botUserModel->where(
                'botuser_id',
                $botuser_id
            )->select(
                'id',
                'created_at',
                'updated_at',
                'botuser_id',
                'status_usr',
                'model_type',
                'limit_req_num',
                'lang'
            )->first();
        } catch (QueryException $e) {
            echo $e;
        }

        if (is_null($user_found)) {

            Log::info( "USER NOT FOUND findByBotuser_id");
//			return abort(404);
            return $user_found;
        }
        // echo "<pre>";
        // echo "USER FOUND $user_found->id\n";
        // echo "</pre>";
        // // $this->foundUserId = $user_found->id;
        (object)$user_found = (object)$user_found->toArray();
        return $user_found;
    }


    public function changeUserStatus(int $id, UsersStatus $userStatus)
    {
        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
        }
        try {
            DB::transaction(function () use ($id, $userStatus) {
                $updateStatus = $this->botUserModel->lockForUpdate()->find($id);
                $updateStatus->status_usr = $userStatus->value;
                $updateStatus->update();
            });
        } catch (QueryException $e) {
            echo($e);
        }

    }

    public function setUserLimit(int $id, int $userLimitNum): void
    {

        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
            // $this->botUserModel = resolve(Botuser::class);
        }
        try {
            $user = $this->botUserModel->find($id);
            // if (is_null($user)) {
            // 	echo ("USER NOT FOUND error message \n");
            // 	return abort(404);
            // }

            $user->limit_req_num = ($user->limit_req_num - $userLimitNum);

            //            $user->limit_req_num = ($user->limit_req_num - $userLimitNum);
            if ($user->limit_req_num < 0) {
                $user->limit_req_num = 0;
                self::changeUserStatus($user->id, UsersStatus::OUT_OF_LIMIT);
            }

            // ['status' => $userStatus->value]
            $user->update();
        } catch (QueryException $e) {
            echo $e;
        }
    }

    public function getUserLimit(int $id): int
    {
        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
        }
        try {
            (object)$userLimit = $this->botUserModel->select('limit_req_num')->find($id);
            if (is_null($userLimit)) {
                Log::info( "USER NOT FOUND getUserLimit");
                //                echo "<font color='red'>" . "USER NOT FOUND error message \n" . "</font>";
//                return abort(404);
            }
        } catch (QueryException $e) {
            echo $e;
        }
        return $userLimit->limit_req_num;
    }

    public function setUserlang(int $id, int $userLang): void
    {

        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
            // $this->botUserModel = resolve(Botuser::class);
        }
        try {
            $user = $this->botUserModel->find($id);
            if (is_null($user)) {
                Log::info( "USER NOT FOUND setUserlang");
                //                echo date("d/m/Y H:i:s") . "USER NOT FOUND error message \n";
            }

            $user->lang = $userLang;
            // ['status' => $userStatus->value]
            $user->update();
        } catch (QueryException $e) {
            echo $e;
        }
    }

    public function setUserRollModel(int $id, int $rollModel): void
    {

        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
            // $this->botUserModel = resolve(Botuser::class);
        }
        try {
            $user = $this->botUserModel->find($id);
            if (is_null($user)) {
                Log::info( "USER NOT FOUND setUserRollModel ");
//                echo date("d/m/Y H:i:s") . "USER NOT FOUND error message \n";
            }

            $user->model_type = $rollModel;
            // ['status' => $userStatus->value]
            $user->update();
        } catch (QueryException $e) {
            echo $e;
        }
    }




    // public function text(int $botUserId)
    // {
    // 	if ($this->messageModel == null) {
    // 		echo "NEW INSTANCE text";
    // 		$this->messageModel = app('message');
    // 	}
    // 	$msg_found = $this->messageModel->where('botuser_id',  $botUserId)->first();
    // }
}


class NewUsers extends Botuser
{
    protected string $botuser_id;

    protected function __construct(string $botuser_id)
    {
        $this->botuser_id = $botuser_id;
    }

    public static function NewUsers(string $botuser_id)
    {
        return new NewUsers($botuser_id);
    }


    public function createUser(): NewUsers
    {

        if ($this->botUserModel === null) {
            $this->botUserModel = app('botuser');
        }
        $token_password = self::generateToken($this->botuser_id);
        $botuser['botuser_id'] = $this->botuser_id;
        $botuser['token'] = $token_password['api_token'];

        try {
            $this->botUserModel->create($botuser);

            echo date("d/m/Y H:i:s") . " Add new user \n";

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                echo date("d/m/Y H:i:s") . "Duplicate unique BotUserID\n";
            } else {
                echo $e->getMessage();
            }
        }
        return $this;
    }


    protected function generateToken(int $data)
    {

        // (object)[
        // 	'password' => Hash::make($data),
        // 	'api_token' => Str::random(60),
        // ];
        return ([
            'password' => Hash::make($data),
            'api_token' => Str::random(60),
        ]);
    }
}
