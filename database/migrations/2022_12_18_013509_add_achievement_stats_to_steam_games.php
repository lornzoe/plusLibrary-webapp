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
        Schema::table('steam_games', function (Blueprint $table) {
            $table->integer('achievements_achieved')->default(0);
            $table->integer('achievements_total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('steam_games', function (Blueprint $table) {
            $table->dropColumn('achievements_achieved');
            $table->dropColumn('achievements_total');
        });
    }
};
