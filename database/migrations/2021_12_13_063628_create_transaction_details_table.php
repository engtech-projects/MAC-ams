<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->increments('transaction_details_id');
            $table->integer('account_id')->nullable();
			$table->integer('transaction_id')->unsigned();
			$table->double('amount')->nullable();
			$table->text('description')->nullable();
			$table->integer('person')->nullable();
			$table->string('person_type')->nullable();
			$table->string('to_increase')->nullable();
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
        Schema::dropIfExists('transaction_details');
    }
}
