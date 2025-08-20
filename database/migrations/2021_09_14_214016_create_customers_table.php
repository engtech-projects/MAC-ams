<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('customer_id');
			$table->string('title')->nullable();
			$table->string('firstname')->nullable();
			$table->string('middlename')->nullable();
			$table->string('lastname')->nullable();
			$table->string('suffix')->nullable();
			$table->string('displayname');
			$table->string('email_address')->nullable();
			$table->string('mobile_number')->nullable();
			$table->string('phone_number')->nullable();
			$table->string('gender')->nullable();
			$table->string('company')->nullable();
			$table->string('birth_date')->nullable();
			$table->string('tin_number')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
