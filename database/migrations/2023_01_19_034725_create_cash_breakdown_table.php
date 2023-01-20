<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashBreakdownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_breakdown', function (Blueprint $table) {
            $table->id("cbreakdown_id");
            $table->integer("onethousand_pesos");
            $table->integer("fivehundred_pesos");
            $table->integer("twohundred_pesos");
            $table->integer("onehundred_pesos");
            $table->integer("fifty_pesos");
            $table->integer("twenty_pesos");
            $table->integer("ten_pesos");
            $table->integer("five_pesos");
            $table->integer("one_peso");
            $table->double("one_centavo");
            $table->double("total_amount");
            $table->timestamps();
        });

        Schema::table('cash_breakdown',function(Blueprint $table){
            $table->unsignedBigInteger('cashblotter_id');
            $table->foreign('cashblotter_id')->references('cashblotter_id')->on('cash_blotter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_breakdown');
    }
}
