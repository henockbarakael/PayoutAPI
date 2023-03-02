<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallbackResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callback_responses', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('comment')->nullable();
            $table->string('trans_status')->nullable();
            $table->string('currency')->nullable();
            $table->string('amount')->nullable();
            $table->string('method')->nullable();
            $table->string('customer_details')->nullable();
            $table->string('reference')->nullable();
            $table->string('paydrc_reference')->nullable();
            $table->string('action')->nullable();
            $table->string('status_description')->nullable();
            $table->string('trans_status_description')->nullable();
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
        Schema::dropIfExists('callback_responses');
    }
}
