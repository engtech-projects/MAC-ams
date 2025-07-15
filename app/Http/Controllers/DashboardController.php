<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardController extends MainController
{

    public function index()
    {


        $title = 'MAC-AMS | Dashboard';



        $subsidiaries = Subsidiary::where('monthly_due', '>', 0)->whereHas('depreciation_payments', function ($query) {
            $query->whereDate('date_paid', '>', Subsidiary::DEPRECIATION_LATEST_DATE);
        })->get();

        $date = Carbon::parse(Subsidiary::DEPRECIATION_LATEST_DATE);

        $subsidiaries->map(function ($subsidiary) use ($date) {
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
                        'date_paid' => $date->addMonth()->format('Y-m-d'),
                    ];
                }
                $subsidiary->depreciation_payments()->createMany($depreciation_payments);
                $payment->delete();
            }
        });
        return view('dashboard.dashboard')->with(compact('title'));
    }
}
