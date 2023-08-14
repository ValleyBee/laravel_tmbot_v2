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
        Schema::create('aibots', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('botuser_id',24);
            $table->integer('user_id')->unsigned();
            $table->integer('message_id');
            $table->string('update_id', 24);
            $table->text('content')->nullable();
            $table->text('reply_from_ai', 24)->nullable();
            $table->tinyInteger('status_msg')->default(0)->unsigned();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aibots');
    }
};
