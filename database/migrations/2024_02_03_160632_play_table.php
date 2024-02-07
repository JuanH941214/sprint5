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
        Schema::create('play', function (Blueprint $table) {
        $table->id();
        $table->integer('diceOne');
        $table->integer('diceTwo');
        $table->integer('sum');
        $table->unsignedBigInteger('user_id')->references('id')->on('users');
        $table->unsignedBigInteger('match_id')->references('id')->on('diceMatch');
        $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_match');
    }
};