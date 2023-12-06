<?php

namespace Database\Seeders;

use App\Models\AccessList;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accessList = [
            [
                "al_id" => 3,
                "module_name" => "Employees",
            ],
            [
                "al_id" => 4,
                "module_name" => "Reports",
            ],
            [
                "al_id" => 5,
                "module_name" => "System Setup",
            ],
            [
                "al_id" => 6,
                "module_name" => "Misc",
            ],
            [
                "al_id" => 7,
                "module_name" => "Dashboard",
            ],
            [
                "al_id" => 8,
                "module_name" => "Chart Of Accounts",
            ],
            [
                "al_id" => 9,
                "module_name" => "Journal",
            ],
            [
                "al_id" => 10,
                "module_name" => "sales",
            ],
            [
                "al_id" => 11,
                "module_name" => "Expenses",
            ],
        ];
        DB::beginTransaction();
        try {
            foreach ($accessList as $access) {
                AccessList::create($access);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }
}
