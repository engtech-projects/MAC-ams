<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
			$table->integer('personalInformation_id')->unsigned();
            $table->string('username');
            $table->string('password');
            $table->string('salt');
            $table->string('status');
            $table->integer('role_id');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

		Schema::table('users', function($table) {
			$table->foreign('personalInformation_id')->references('personalInformation_id')->on('personal_info');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
