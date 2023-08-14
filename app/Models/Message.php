<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Message extends Model
{
	use HasFactory;

	protected $guarded = [];


	// public int $message_id;
	// public int $update_id;
	// public int $user_id;
	// public int $botuser_id;
	// public string $first_name;
	// public string $last_name;
	// public string $content;
	// public int $status;

	// public function botusers()
	// {
	// 	$this->belongsTo(Botuser::class);
	// }
}
