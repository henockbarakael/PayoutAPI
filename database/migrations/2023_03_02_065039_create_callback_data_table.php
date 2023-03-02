<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallbackDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callback_data', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('telco_reference')->nullable();
            $table->string('switch_reference')->nullable();
            $table->string('paydrc_reference')->nullable();
            $table->string('action')->nullable();
            $table->string('telco_status_description')->nullable();
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
        Schema::dropIfExists('callback_data');
    }
}
