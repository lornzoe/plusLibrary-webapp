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
        Schema::create('walletdata_purchase', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('appid'); // identifier
            $table->text('label');
            $table->decimal('cost');
            $table->boolean('dlcmtxflag')->default(false);
            $table->date('date_obtained');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('walletdata_purchase');
    }
};
