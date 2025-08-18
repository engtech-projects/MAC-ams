<?php

namespace Database\Seeders;

use App\Models\Subsidiary;
use Illuminate\Database\Seeder;

class MonthlyDueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $subsidiaries = Subsidiary::all();
        Subsidiary::withoutEvents(function () use ($subsidiaries) {
            foreach ($subsidiaries as $subsidiary) {
                $monthlyDue = $subsidiary['sub_amount'] - $subsidiary['sub_salvage'] / $subsidiary['sub_no_depre'];
                Subsidiary::where('sub_id', $subsidiary['sub_id'])->update(['monthly_due' => $monthlyDue]);
            }
        });
    }
}
