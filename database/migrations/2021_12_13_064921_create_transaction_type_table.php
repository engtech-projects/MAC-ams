<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_type', function (Blueprint $table) {
            $table->increments('transaction_type_id');
			$table->string('transaction_type')->nullable();
			$table->integer('transaction_category_id')->nullable();
			$table->integer('visible')->nullable();
			$table->integer('account_id')->nullable();
			$table->integer('counter_account_id')->nullable();
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
        Schema::dropIfExists('transaction_type');
    }
}
