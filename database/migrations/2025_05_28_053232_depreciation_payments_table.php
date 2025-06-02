<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DepreciationPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depreciation_payments', function (Blueprint $table) {
            $table->id('id');
            $table->double('amount');
            $table->integer('sub_id');
            $table->date('date_paid');
            $table->foreign('sub_id')
                ->references('sub_id')
                ->on('subsidiary')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('depreciation_payments', function (Blueprint $table) {
            $table->dropForeign(['sub_id']);
            $table->dropColumn('sub_id');
        });
        Schema::dropIfExists('depreciation_payments');
    }
}