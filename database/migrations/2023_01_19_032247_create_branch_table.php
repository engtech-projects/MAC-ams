<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('branch')) {
            Schema::create('branch', function (Blueprint $table) {
                $table->id("branch_id");
                $table->string("branch_name");
                $table->string("branch_code");
                $table->string("branch_manager");
                $table->string("branch_address");
                $table->string("status");
                $table->integer("deleted");
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch');
    }
}