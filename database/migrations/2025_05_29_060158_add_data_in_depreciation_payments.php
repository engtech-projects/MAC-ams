<?php

use App\Models\DepreciationPayment;
use App\Models\Subsidiary;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataInDepreciationPayments extends Migration
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
                $amount = $subsidiary['sub_no_amort'] * $subsidiary['monthly_due'];
                $date_paid = now();
                if ($amount != 0) {
                    $subsidiary->depreciation_payments()->create([
                        'sub_id' => $subsidiary->sub_id,
                        'amount' => round($amount,2),
                        'date_paid' => $date_paid,
                    ]);
                }
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
        Schema::table('depreciation_payments', function (Blueprint $table) {
            //
        });
    }
}