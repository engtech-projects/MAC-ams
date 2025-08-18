<?php

use App\Models\Subsidiary;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataInColumnMonthlyDueSubsidiaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $subsidiaries = Subsidiary::all();
        Subsidiary::withoutEvents(function () use ($subsidiaries) {
            foreach ($subsidiaries as $subsidiary) {
                $monthlyDue = $subsidiary['sub_no_depre'] != 0 ? ($subsidiary['sub_amount'] - ($subsidiary['sub_amount'] * ($subsidiary['sub_salvage'] / 100))) / $subsidiary['sub_no_depre'] : 0.00;
                Subsidiary::where('sub_id', $subsidiary['sub_id'])->update(['monthly_due' => $monthlyDue]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('column_monthly_due_subsidiary', function (Blueprint $table) {
            //
        });
    }
}
