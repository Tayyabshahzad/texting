<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'phone' => rand(1000000, 999999),
            'password' => Hash::make('password'),
        ]);

        $user = new User;
        $user->name = "admin";
        $user->phone = "1122334455";
        $user->password = Hash::make('password');
        $user->save();
        $user->assignRole('Super-Admin');


        $user = new User;
        $user->name = "customer";
        $user->phone = "1112223334";
        $user->password = Hash::make('password');
        $user->save();
        $user->assignRole('Customer');

        $user = new User;
        $user->name = "User";
        $user->phone = "0102030405";
        $user->password = Hash::make('password');
        $user->save();
        $user->assignRole('User');
    }
}
