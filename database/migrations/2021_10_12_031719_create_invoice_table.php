<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('invoice_id');
			$table->integer('transaction_id')->unsigned();
            $table->string('invoice_no')->unique();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('term_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->double('total_amount', 10, 2);
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
        Schema::dropIfExists('invoice');
    }
}
