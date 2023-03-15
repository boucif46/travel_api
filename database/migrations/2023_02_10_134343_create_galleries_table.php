<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {  if (!Schema::hasTable('galeries')) {
        Schema::create('galeries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('travel_place_id');
            $table->string('image_url');
            $table->timestamps();

            $table->foreign('travel_place_id')
                  ->references('id')->on('travel_places')
                  ->onDelete('cascade');
        });
    }}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galeries');
    }
};
