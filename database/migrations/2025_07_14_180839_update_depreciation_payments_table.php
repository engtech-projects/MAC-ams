<?php

use App\Models\Subsidiary;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
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
        $subsidiaries = Subsidiary::where('monthly_due', '>', 0)->whereHas('depreciation_payments', function ($query) {
            $query->whereDate('date_paid', '>', Subsidiary::DEPRECIATION_LATEST_DATE);
        })->get();
        $orginalDate = Carbon::parse(Subsidiary::DEPRECIATION_LATEST_DATE);
        Subsidiary::withoutEvents(function () use ($subsidiaries, $orginalDate) {
            $newDate = $orginalDate->copy();
            $subsidiaries->map(function ($subsidiary) use ($newDate) {
                $used = $subsidiary->sub_no_amort;
                $number_of_paid = $subsidiary->depreciation_payments->count();
                $used = $used - $number_of_paid;
                $payments = $subsidiary->depreciation_payments;
                $depreciation_payments = [];

                foreach ($payments as $payment) {
                    $amount = $used != 0 ? $payment->amount / $used : 0;
                    foreach (range(1, $used) as $i) {
                        $depreciation_payments[] = [
                            'sub_id' => $subsidiary->sub_id,
                            'amount' => round($amount, 2),
                            'date_paid' => $newDate->addMonth()->day(30)->format('Y-m-d'),
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
