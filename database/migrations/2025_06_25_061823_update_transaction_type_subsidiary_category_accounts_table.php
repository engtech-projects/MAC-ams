<?php

use App\Models\SubsidiaryCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransactionTypeSubsidiaryCategoryAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* $subsidiaryCategory = SubsidiaryCategory::with(['accounts'])->where('sub_cat_type',"depre")->get();
        foreach($subsidiaryCategory as $category) {
            $ca
        } */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
