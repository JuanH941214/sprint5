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
        Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->integer('diceOne');
        $table->integer('diceTwo');
        $table->integer('sum');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('match_id');
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('create_users_table');
        $table->foreign('match_id')->references('id')->on('diceMatch');
        


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
