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
        Schema::create('purchase_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('appid');
            $table->string('desc')->nullable();
            $table->decimal('cost')->nullable();
            $table->boolean('is_initial')->default(true);
            $table->date('date_of_purchase')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purchase_records');
    }
};
