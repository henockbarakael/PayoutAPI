<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_id')->nullable();
            $table->string('merchant_code')->nullable();
            $table->string('merchant_secrete')->nullable();
            $table->string('institution_code')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('logo')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('status')->nullable();
            $table->integer('niveau')->nullable();
            $table->string('user_status')->nullable();
            $table->string('role_name')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('salt')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
