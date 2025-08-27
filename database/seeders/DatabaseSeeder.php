<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Currency;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(AccessListSeeder::class);
        $this->call(SubModuleListSeeder::class);
        $this->call(AccessibilitiesSeeder::class);

        $currency =    [
            'PHP' => 'Philippine Peso',
            'USD' => 'US Dollars'
        ];

        foreach ($currency as $key => $value) {
            $cc = new Currency;
            $cc->currency = $value;
            $cc->abbreviation = $key;
            $cc->save();
        }
    }
}
