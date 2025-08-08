<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAoCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ao_collection')) {
            Schema::create('ao_collection', function (Blueprint $table) {
                $table->id('aocollection_id');
                $table->string('remarks');
                $table->double('total_amount', 10, 2)->nullable();
                $table->timestamps();
            });

            /* Schema::table('ao_collection', function (Blueprint $table) {
                $table->unsignedBigInteger('accountofficer_id');
                $table->foreign('accountofficer_id')->references('accountofficer_id')->on('account_officer');

                $table->unsignedBigInteger('cashblotter_id');
                $table->foreign('cashblotter_id')->references('cashblotter_id')->on('cash_blotter');
            }); */
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ao_collection');
    }
}
