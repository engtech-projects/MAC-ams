<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_addresses', function (Blueprint $table) {
            $table->increments('address_id');
			$table->string('street')->nullable();
			$table->string('city')->nullable();
			$table->string('province')->nullable();
			$table->string('zip_code')->nullable();
			$table->string('country')->nullable();
			$table->text('notes')->nullable();
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('employee_id')->on('employees');
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
        Schema::dropIfExists('employee_addresses');
    }
}
