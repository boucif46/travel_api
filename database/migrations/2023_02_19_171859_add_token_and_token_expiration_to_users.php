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
        Schema::table('users', function (Blueprint $table) {
             // Delete the "email_verified_at" column
             $table->dropColumn('email_verified_at');
             $table->dropColumn('remember_token');
             // Add two new columns "first_name" and "last_name"
             $table->string('jwt_token')->nullable();
             $table->timestamp('jwt_token_expiration')->nullable();
         });
            //
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('email_verified_at');
             $table->dropColumn('remember_token');
             // Add two new columns "first_name" and "last_name"
             $table->string('jwt_token')->nullable();
             $table->timestamp('jwt_token_expiration')->nullable();
        });
    }
};
