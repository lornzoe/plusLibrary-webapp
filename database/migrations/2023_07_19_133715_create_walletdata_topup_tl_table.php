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
        Schema::create('walletdata_topup_tl', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->decimal('tlcost')->default(0.01);
            $table->decimal('sgdcost')->default(0.01);
            $table->date('date_obtained');
            $table->decimal('tlleftover')->default(0.01);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('walletdata_topup_tl');
    }
};
