<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->increments('supplier_id');
            $table->string('title');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('suffix');
            $table->string('displayname');
            $table->string('email_address');
            $table->string('mobile_number');
            $table->string('phone_number');
            $table->string('company');
            $table->string('tin_number');
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
        Schema::dropIfExists('supplier');
    }
}
