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
        Schema::table( 'purchase_records', function (Blueprint $table){
            $table->decimal('cost', total: 10, places:4)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table( 'purchase_records', function (Blueprint $table){
            $table->decimal('cost', total: 8, places:2)->change();
        });
    }
};
