<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_info', function (Blueprint $table) {
			$table->increments('personalInformation_id');
			$table->string('firstname');
			$table->string('middlename');
			$table->string('lastname');
			$table->string('gender')->nullable();
			$table->string('displayname');
			$table->string('email_address')->nullable();
			$table->string('mobile_number')->nullable();
			$table->string('phone_number')->nullable();
			$table->date('birth_date')->nullable();
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
        Schema::dropIfExists('personal_info');
    }
}
