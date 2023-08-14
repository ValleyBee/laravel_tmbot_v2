<?php

namespace App\Models;

use App\Enums\Messages\Status as MessageStatus;
use App\Http\Controllers\BotsMessages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// use App\Enums\Tmbot\Status;
//use App\Models\Message;
use stdClass;


class Botmessages extends Model
{
    use HasFactory;

    protected static $ms = '';
    protected $guarded = [];

    // can make custom casts
    // protected $casts = [
    // 	'status' => Status::class
    // ];

    public function botusers()
    {
        $this->belongsTo(Botuser::class);
    }

    protected ?Botmessages $messageModel = null;


    // public int $message_id;
    // protected int $update_id;
    // public int $botuser_id;
    // protected string $first_name;
    // protected string $last_name;
    // protected string $content;
    // protected int $status;


    /*return int id or 0 if not found */
    public function getLastMsgWithStatusSetBusy(Botmessages $messageModel,MessageStatus $status): stdClass|null
    {

        $result = null;
//        echo "transactionLevel " . DB::connection(DB::getDefaultConnection())->transactionLevel();

        if (DB::connection(DB::getDefaultConnection())->transactionLevel() == 0) {
            DB::beginTransaction();
        }
        try {
            $withStatus = $messageModel->where('status_msg', $status->value)
                ->latest('created_at')
                ->sharedLock()
                ->first();
            if ($withStatus !== null) {
//				echo "setMsgStatusOnBusy";
                (object)$result = (object)$withStatus->toArray();
                $withStatus->status_msg = MessageStatus::BUSY;
                $withStatus->update();
            }
//            echo "transactionLevel " . DB::connection(DB::getDefaultConnection())->transactionLevel() . "\n";

            DB::commit();


        } catch (QueryException $e) {
            DB::rollback();
            echo($e);
            throw $e;
        }
        return $result;
    }

    public function getLastMsgWithStatusReplySetDone(Botmessages $messageModel): stdClass|null
    {
        echo "METHOD getLastMsgIdWithStatusNull";
        $result = null;
        echo "transactionLevel " . DB::connection(DB::getDefaultConnection())->transactionLevel();

        if (DB::connection(DB::getDefaultConnection())->transactionLevel() == 0) {
            DB::beginTransaction();
        }
        try {
            $withStatus = $messageModel->where('status_msg', MessageStatus::REPLY)
                ->latest('created_at')
                ->sharedLock()
                ->first();
            if ($withStatus !== null) {
//				echo "setMsgStatusOnBusy";
//                dd($withStatus);
                (object)$result = (object)$withStatus->toArray();
                $withStatus->status_msg = MessageStatus::DONE;
                $withStatus->update();
            }
            echo "transactionLevel " . DB::connection(DB::getDefaultConnection())->transactionLevel() . "\n";
            echo "<br>";
            DB::commit();

            return $result;
        } catch (QueryException $e) {
            DB::rollback();
            echo($e);
            throw $e;
        }

    }




//        try {
//
//            $withStatus = $messageModel->where('status_msg', $status->value)
//                ->latest('created_at')
//                ->first();
//        } catch (QueryException $e) {
//            echo($e);
//        }
//
//        if ($withStatus !== null) {
////				echo "setMsgStatusOnBusy";
//            $messageModel->setStatusMessage($withStatus->id, MessageStatus::BUSY);
//            (object)$withStatus = (object)$withStatus->toArray();
//            return $withStatus;
//        }
//
//        return $withStatus;



    public function getLastMsgIdWithStatusDelay(): ?stdClass
    {
        $withStatus = null;
        $last_session = Storage::get('last_session.data');
        echo "METHOD getLastMsgIdWithStatusDelay";
        echo "LAST SESSION TIME: " . $last_session;
        echo "CURRENT TIME: " . date('H:i:s');

        if ((time() - 60) <= ($last_session)) {
            exit();
        }
        if ($this->messageModel === null) {
            $this->messageModel = app('botmessage');
        }
        try {
            $withStatus = $this
                ->where('status_msg', MessageStatus::DELAY)
                ->oldest('created_at')
                ->first();

        } catch (QueryException $e) {
            echo($e);
        }

        if ($withStatus !== null) {
//				echo "setMsgStatusOnBusy";
            $this->setStatusMessage($withStatus->id, MessageStatus::BUSY);
            (object)$withStatus = (object)$withStatus->toArray();
            return $withStatus;
        }

        return $withStatus;
    }


    public function getLastRecordUpdate_id(): stdClass
    {

        (object)$msg_found = null;

        try {
            $msg_found = $this->latest('id')->first();
//			echo (memory_get_usage());
//            dd($msg_found->update_id);
        } catch (QueryException $e) {
            echo($e);
        }

        if (is_null($msg_found)) {
            echo('message NOT FOUND error message');
            //            return abort(404);
            $msg_found = new stdClass();
            $msg_found->update_id = null;
            return $msg_found;
        }
        (object)$msg_found = (object)$msg_found->toArray();
//                     dd($msg_found);

//        echo "<pre>";
//        echo "message found \n";
//        echo "</pre>";
        return $msg_found;
//        select *from getLastRecord ORDER BY id DESC LIMIT 1;

    }

    public function getLastReplyById(int $user_id): ?string
    {
        (object)$withReply = null;

        try {
            echo "getLastReplayMsg";
            $withReply = $this->where('status_msg', MessageStatus::DONE)
                ->whereNotNull('reply_from_ai')
                ->where('user_id', $user_id)
                ->latest('created_at')
                ->first();
        } catch (QueryException $e) {
            echo($e);
        }
        if ($withReply !== null) {
            $withReply->toArray();
            return $withReply->reply_from_ai;
        }
        return null;
    }


    public function getMsgById(int $id): ?stdClass
    {
        (object)$msg_found = null;
        // if ($this->messageModel === null) {
        // 	$this->messageModel = app('message');
        // }
        try {
            $msg_found = $this->find($id);
        } catch (QueryException $e) {
            echo($e);
        }
        if (is_null($msg_found)) {
            echo('message NOT FOUND error message');
            return abort(404);
            // return $msg_found;
        }
        (object)$msg_found = (object)$msg_found->toArray();

//		echo "message found \n";

        return $msg_found;
    }

    public function getMessageByMsg_Id(int $msg_id): stdClass|null
    {
        (object)$msg_found = null;

        try {
            $msg_found = $this->where('message_id', $msg_id)->first();
//			echo (memory_get_usage());
            // dd($withStatus);
        } catch (QueryException $e) {
            echo($e);
        }

        if (is_null($msg_found)) {
            echo('message NOT FOUND error message');
            return abort(404);
            // return $msg_found;
        }
        (object)$msg_found = (object)$msg_found->toArray();


        return $msg_found;
    }

    public function getMsgByUser_pk_id(int $user_pk_id): stdClass|null
    {
        (object)$msg_found = null;

        try {
            $msg_found = $this->where('user_id', $user_pk_id)->first();

            // dd($withStatus);
        } catch (QueryException $e) {
            echo($e);
        }

        if (is_null($msg_found)) {
            echo date("d/m/Y H:i:s") . "message NOT FOUND error message\n";
            return abort(404);
            // return $msg_found;
        }
        (object)$msg_found = (object)$msg_found->toArray();

        echo date("d/m/Y H:i:s") . " Message found \n";

        return $msg_found;
    }


    public function setMsgDoneWithReplay(int $id, array $answerFromAI = null)
    {
        if ($this->messageModel === null) {
            $this->messageModel = app('botmessage');
        }
        try {
            DB::transaction(function () use ($id, $answerFromAI) {
                $updateStatus = $this->messageModel->lockForUpdate()->find($id);
                $updateStatus->reply_from_ai =
                    $answerFromAI['choices'][0]['message']['content'];
                $updateStatus->status_msg = MessageStatus::DONE;
                $updateStatus->update();
            });
        } catch (QueryException $e) {
            echo($e);
        }

    }

    public function setStatusMessage(int $id, MessageStatus $MessageStatus): void
    {
        echo date("d/m/Y H:i:s") . " METHOD setStatusMessage";
        if ($this->messageModel === null) {
            $this->messageModel = app('botmessage');
        }
        try {
            DB::transaction(function () use ($id, $MessageStatus) {
                $updateStatus = $this->messageModel->lockForUpdate()->find($id);
                $updateStatus->status_msg = $MessageStatus->value;

                $updateStatus->update();
            });
        } catch (QueryException $e) {
            echo($e);
        }
    }


    public function allMessages()
    {

        if ($this->messageModel === null) {
            $this->messageModel = app('botmessage');
        }
        try {

            $message = $this->messageModel->all();
            $content = $message->orderBy('botuser_id')->orderBy('created_at', 'desc')->get();
        } catch (QueryException $e) {
            echo($e);
        }

        return redirect();
    }

    public function findIsMsgExistByMsg_id(int $message_id): int | null
    {
        if ($this->messageModel == null) {
            $this->messageModel = app('botmessage');
        }
        try {
            $msg_found = $this->where('message_id', $message_id)->first();
            // var_dump($this->messageModel);

            if ($msg_found == null) {

                echo date("d/m/Y H:i:s") . "message not exist  MESSAGE ID: $message_id;\n";

                return null;
            }
        } catch (QueryException $e) {
            echo $e;
        }

        echo date("d/m/Y H:i:s") . " " . "message exist MESSAGE ID: $message_id\n";

        return $msg_found->id;
    }


    public function storeOnlyNewTmMesssages(int $user_id, stdClass $responseFields): int
    {

        if ($this->messageModel == null) {
            $this->messageModel = app('botmessage');
        }
        try {
            $result = DB::transaction(function () use ($user_id, $responseFields) {
                $responseFields->user_id = $user_id;
                return $this->messageModel->lockForUpdate()->create((array)$responseFields);
            });

        } catch (QueryException $e) {
            echo($e);
        }
        return $result->id;
    } // end of store


    // public function storeMesssages(int $botUserId, array $responseFields)
    // {
    // 	// var_dump($this->botUserModel);
    // 	if ($this->messageModel == null) {
    // 		echo "NEW INSTANCE message";
    // 		$this->messageModel = app('message');
    // 	}
    // 	try {
    // 		$msg_found = $this->messageModel->where('message_id',  $responseFields['message_id'])->first();

    // 		// var_dump($msg_found, $responseFields['message_id']);

    // 		if ($msg_found == []) {
    // 			$responseFields['user_id'] = $botUserId;

    // 			// dd($message);
    // 			$this->messageModel->create($responseFields);
    // 			echo "<pre>";
    // 			echo "add new message\n";
    // 			echo "</pre>";
    // 			// var_dump($this->messageModel);

    // 		} else {
    // 			// var_dump($this->messageModel);
    // 			echo "<pre>";
    // 			echo "message exist\n";
    // 			echo "</pre>";
    // 		}

    // 		// not found


    // 	} catch (QueryException $e) {
    // 		echo $e;
    // 	}
    // } // end of store


}
