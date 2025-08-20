<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAdressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_address', function (Blueprint $table) {
			$table->increments('address_id');
			$table->string('address_type');
			$table->string('street')->nullable();
			$table->string('city')->nullable();
			$table->string('province')->nullable();
			$table->string('zip_code')->nullable();
			$table->string('country')->nullable();
			$table->integer('customer_id')->unsigned();
			$table->foreign('customer_id')->references('customer_id')->on('customer');
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
        Schema::dropIfExists('customer_adresses');
    }
}
