<?php

use App\Models\Subsidiary;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDepreciationPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $subsidiaries = Subsidiary::where('monthly_due', '>', 0)->whereHas('depreciation_payments', function ($query) {
            $query->whereDate('date_paid', '>', Subsidiary::DEPRECIATION_LATEST_DATE);
        })->get();
        $orginalDate = Carbon::parse(Subsidiary::DEPRECIATION_LATEST_DATE);
        Subsidiary::withoutEvents(function () use ($subsidiaries, $orginalDate) {

            $subsidiaries->map(function ($subsidiary) use ($orginalDate) {
                $newDate = $orginalDate->copy();
                $used = $subsidiary->sub_no_amort;
                $payments = $subsidiary->depreciation_payments;
                $depreciation_payments = [];

                foreach ($payments as $payment) {
                    $amount = $used != 0 ? $subsidiary->sub_amount / $used : 0;
                    foreach (range(1, $used) as $i) {
                        $depreciation_payments[] = [
                            'sub_id' => $subsidiary->sub_id,
                            'amount' => $amount,
                            'date_paid' => $newDate->format('Y-m-d'),
                        ];
                        $newDate = $newDate->startOfMonth()->subMonth()->endOfMonth();
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
