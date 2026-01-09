<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsAndServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_and_services', function (Blueprint $table) {
            $table->increments('item_id');
            $table->string('name')->unique();
            $table->string('type')->nullable();
            $table->string('sku')->nullable();
            $table->integer('qty_on_hand')->nullable();
            $table->integer('reorder_point')->nullable();
            $table->double('rate', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('income_account')->unsigned()->nullable();
			$table->integer('ps_category_id')->nullable();
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
        Schema::dropIfExists('products_and_services');
    }
}
