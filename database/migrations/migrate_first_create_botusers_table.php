<?php

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
		Schema::create('botusers', function (Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->string('botuser_id', 24);
			$table->string('token', 60)->uniqid();
			$table->tinyInteger('status_usr')->default(0)->unsigned();
			$table->tinyInteger('model_type')->default(0)->unsigned();
			$table->integer('limit_req_num')->default(0)->unsigned();
			$table->tinyInteger('lang')->default(0)->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('botusers');
	}
};
