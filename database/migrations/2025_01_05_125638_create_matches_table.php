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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('user_1_id');
            $table->integer('user_2_id');
            $table->string('user_1_name');
            $table->string('user_2_name');
            $table->integer('user_1_elo');
            $table->integer('user_2_elo');
            $table->integer('user_1_elo_change');
            $table->integer('user_2_elo_change');
            $table->integer('user_1_score');
            $table->integer('user_2_score');
            $table->integer('winner');
            $table->string('game');
            $table->string('playgroup');
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
