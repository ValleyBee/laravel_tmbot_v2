<?php

use App\Models\Botuser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('botmessages', function (Blueprint $table) {
			$table->id();
            $table->timestamps();
			$table->string('botuser_id',24);
			$table->integer('message_id')->unsigned();
			$table->string('update_id', 24);
			$table->string('first_name', 256);
			$table->string('last_name', 256);
			$table->text('content')->nullable();
			$table->text('reply_from_ai', 24)->nullable();
			$table->tinyInteger('status_msg')->default(0)->unsigned();
        });

        Schema::table('botmessages', function (Blueprint $table) {
            $table->foreignId('user_id')->references('id')->on('botusers')->constrained();
        });
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('botmessages');
	}
};
