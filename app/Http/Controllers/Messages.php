<?php

namespace App\Http\Controllers;

use App\Enums\Messages\Status;
use App\Enums\Messages\Status as MessageStatus;
use App\Http\Controllers\BotsMessages;
use Illuminate\Http\Request;

class Messages extends Controller
{

    public function start(){


        BotsMessages::runner(MessageStatus::DELAY);


    }


}
