<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSubsidiaryCategoryAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subsidiary_category_accounts', function (Blueprint $table) {
            $table->string('transaction_type'); // Example: Add string column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subsidiary_category_accounts', function (Blueprint $table) {
            $table->dropColumn('transaction_type');
        });
    }
}
