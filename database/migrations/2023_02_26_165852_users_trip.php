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
        Schema::create('usersTrips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('destination_id');
            $table->unsignedBigInteger('user_id');
            $table->string('destination_name');
            $table->string('name');
            $table->string('last_name');
            $table->date('starting_trip');
            $table->date('ending_trip');
            $table->integer('adult_number');
            $table->integer('children_number');
            $table->boolean('confirmed')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('destination_id')->references('id')->on('travel_places');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usersTrips');
    }
};
