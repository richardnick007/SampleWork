<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
   

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('bank_code');
            $table->String('account_number');
            $table->string('amount');
            $table->string('full_name');
            $table->string('currency');
            $table->string('debit_currency');
            $table->string('narration');
            $table->string('fee');
            $table->string('status');
            $table->integer('requires_approval');
            $table->integer('is_approved');
            $table->string('bank_name');
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
        Schema::dropIfExists('transactions');
    }
}
