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
        Schema::create('steam_monthly_snapshots', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('appid'); // identifier.
            $table->smallInteger('timestamp_year')->default(0);
            $table->smallInteger('timestamp_month')->default(0);
            $table->integer('playtime')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('steam_monthly_snapshots');
    }
};
