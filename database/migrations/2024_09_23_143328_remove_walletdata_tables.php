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
        //
        Schema::dropIfExists('walletdata_purchase');
        Schema::dropIfExists('walletdata_purchase_tl');
        Schema::dropIfExists('walletdata_topup_tl');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::create('walletdata_purchase', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('appid'); // identifier
            $table->text('label');
            $table->decimal('cost');
            $table->boolean('dlcmtxflag')->default(false);
            $table->date('date_obtained');
        });

        Schema::create('walletdata_purchase_tl', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('recordid')->default(0);
            $table->decimal('tlcost')->default(0);
            $table->decimal('sgdcost')->nullable();
        });

        Schema::create('walletdata_topup_tl', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->decimal('tlcost')->default(0.01);
            $table->decimal('sgdcost')->default(0.01);
            $table->date('date_obtained');
            $table->decimal('tlleftover')->default(0.01);
        });
    }
};
