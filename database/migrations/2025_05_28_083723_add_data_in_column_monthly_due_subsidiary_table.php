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
                /* $result = $denominator != 0 ? $numerator / $denominator : null; */

                $monthlyDue = $subsidiary['sub_no_depre'] != 0 ? $subsidiary['sub_amount'] - $subsidiary['sub_salvage'] / $subsidiary['sub_no_depre'] : 0.00;
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
