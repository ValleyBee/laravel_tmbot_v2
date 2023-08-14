<?php

namespace App\Enums\Users;

enum Status: int
{
	case NEW_USER = 0;
	case NOT_AUTHORIZED = 1;
	case AUTHORIZED = 2;
	case BAN_TIME2 = 3;
	case OUT_OF_LIMIT = 4;
	case VIOLATION = 5;
	case DELETED = 6;




	public function text()
	{
		return match ($this->value) {
			self::NOT_AUTHORIZED->value => 'waiting for authorization',
			self::AUTHORIZED->value => 'allowed sending a messasge',
			self::NEW_USER->value => 'new user',
			self::BAN_TIME2->value => 'ban for a while',
			self::OUT_OF_LIMIT->value => 'limit on requests has been reach',
			self::VIOLATION->value => 'violation the rules of OpenAI',
			self::DELETED->value => 'deletet forever'
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

	public static function out_of_limit()
	{
		return self::OUT_OF_LIMIT;
	}
}
