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
        Schema::table('travel_places', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable();
            $table->unsignedDecimal('longitude', 11, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

     
    public function down()
    {
        Schema::table('travel_places', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable();
            $table->unsignedDecimal('longitude', 11, 8)->nullable();
        });
    }
};
