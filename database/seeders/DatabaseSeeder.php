<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Currency;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'salt' => Str::random(10),
            'status' => 'active',
            'role_id' => 1,

        ]);

        $this->call(AccessListSeeder::class);
        $this->call(SubModuleListSeeder::class);
        $this->call(MonthlyDueSeeder::class);
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
