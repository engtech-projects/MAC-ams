<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\SubModuleList;
use App\Models\Accessibilities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::upsert(
            [
                [
                    'id' => 1,
                    'username' => 'admin',
                    'password' => Hash::make('admin'),
                    'salt'     => Str::random(10),
                    'status'   => 'active',
                    'role_id'  => 1,
                ]
            ],
            ['id'],
            ['role_id']
        );

        $admin = User::find(1);
        $userAccess = Accessibilities::where('user_id', 1)->pluck('sml_id');
        $subModules = SubModuleList::all()->pluck('sml_id');
        $toDelete = array_diff($userAccess->toArray(), $subModules->toArray());
        $toInsert = array_diff($subModules->toArray(), $toDelete);

        Accessibilities::where('sml_id', $toDelete)->where('user_id', $admin->id)->delete();

        $insertData = array_map(function ($sml_id) use ($admin) {
            return [
                'user_id' => $admin->id,
                'sml_id'  => $sml_id,
            ];
        }, $toInsert);
        $admin->accessibilities()->createMany($insertData);
    }
}
