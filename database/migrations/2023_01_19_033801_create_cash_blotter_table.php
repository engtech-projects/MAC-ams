<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashBlotterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_blotter', function (Blueprint $table) {
            $table->id('cashblotter_id');
            $table->date('transaction_date');
            $table->double('total_collection');
            $table->timestamps();
        });

        Schema::table('cash_blotter',function(Blueprint $table){
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('branch_id')->on('branch');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_blotter');
    }
}
