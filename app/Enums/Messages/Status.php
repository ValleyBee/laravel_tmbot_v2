<?php

namespace App\Enums\Messages;

enum Status: int
{
	case PENDING = 0;
	case BUSY = 1;
	case MENU = 2;
	case REJECT = 3;
	case VIOLATION = 4;
    case DELAY = 5;
    case NODELAY = 6;
    case REPLY = 7;
    case TMSEND = 8;
    case DONE = 9;



	public function text()
	{
		return match ($this->value) {
			self::PENDING->value => 'waiting for run',
			self::BUSY->value => 'waiting to be finished',
			self::MENU->value => 'Keyboard buttom of menu',
			self::REJECT->value => 'message reject migth be too short or other reasons',
			self::VIOLATION->value => 'violation the rules of OpenAI',
            self::DELAY->value => 'message can be send to AI with delay',
            self::NODELAY->value => 'message can be send to AI without delay',
            self::REPLY->value => 'message has reply from AI can be to tm-bot',
            self::TMSEND->value => 'message can be to tm-bot',
            self::DONE->value => 'done'
		};
	}



	public static function toArray()
	{
		$names = [];

		foreach (self::cases() as $props) {
			array_push($names, $props->name);
		}

		return $names;
	}


	public static function toAssociativeArray(): array
	{
		$array = array();
		foreach (self::cases() as $case) {
			$array[] = ['id' => $case->value, 'name' => $case->name];
		}
		return $array;
	}






	public function busy()
	{
		return  self::BUSY;
	}
}
