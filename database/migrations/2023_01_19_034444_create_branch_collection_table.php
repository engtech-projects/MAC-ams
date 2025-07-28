<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('transaction_category')) {
            Schema::create('branch_collection', function (Blueprint $table) {
                $table->id('branchcollection_id');
                $table->double('total_amount', 10, 2)->nullable();

                $table->timestamps();
            });

            Schema::table('branch_collection', function (Blueprint $table) {
                $table->unsignedBigInteger('cashblotter_id');
                $table->foreign('cashblotter_id')->references('cashblotter_id')->on('cash_blotter');

                $table->unsignedBigInteger('branch_id');
                $table->foreign('branch_id')->references('branch_id')->on('branch');
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
        Schema::dropIfExists('branch_collection');
    }
}
