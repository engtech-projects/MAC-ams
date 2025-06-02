<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonthlyDueToSubsidiaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subsidiary', function (Blueprint $table) {
            $table->double('monthly_due', 8, 2)->default(0.00)->after('sub_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subsidiary', function (Blueprint $table) {
            $table->dropColumn('monthly_due');
        });
    }
}
