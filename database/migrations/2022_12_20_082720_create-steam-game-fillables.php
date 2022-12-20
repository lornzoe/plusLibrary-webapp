<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steam_game_fillables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('appid'); // identifier.
            $table->decimal('cost_initial')->nullable();
            $table->decimal('cost_additional')->nullable();

            $table->date('date_obtained')->nullable();

            $table->integer('rating')->nullable();
            $table->text('thoughts')->nullable();
            $table->boolean('completed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('steam_game_fillables');
    }
};
