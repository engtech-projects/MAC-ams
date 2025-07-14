<?php

use App\Models\Subsidiary;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDepreciationPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $subsidiaries = Subsidiary::where('monthly_due', '>', 0)->whereHas('depreciation_payments')->get();
        Subsidiary::where('monthly_due', '>', 0)->whereHas('depreciation_payments')->withoutEvents(function () use ($subsidiaries) {
            $subsidiaries->forEach(function ($subsidiary) {
                $used = $subsidiary->sub_no_amort;
                $payments = $subsidiary->depreciation_payments;
                $depreciation_payments = [];
                foreach ($payments as $payment) {
                    $amount = $payment->amount / $used;
                    foreach (range(1, $used) as $i) {
                        $depreciation_payments[] = [
                            'sub_id' => $subsidiary->sub_id,
                            'amount' => $amount,
                            'date_paid' => now(),
                        ];
                    }
                    $subsidiary->depreciation_payments()->createMany($depreciation_payments);
                    $payment->delete();
                }
            });
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
    }
}