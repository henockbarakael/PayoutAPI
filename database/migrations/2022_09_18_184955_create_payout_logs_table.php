<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payout_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action')->nullable();
            $table->double('amount')->nullable();
            $table->string('comment')->nullable();
            $table->string('created_at')->nullable();
            $table->string('currency')->nullable();
            $table->string('debit_account')->nullable();
            $table->string('debit_channel')->nullable();
            $table->string('destination_account')->nullable();
            $table->string('destination_channel')->nullable();
            $table->string('financial_institution_transaction_id')->nullable();
            $table->string('merchant_ref')->nullable();
            $table->string('status')->nullable();
            $table->string('trans_id')->nullable();
            $table->string('transaction_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payout_logs');
    }
}
