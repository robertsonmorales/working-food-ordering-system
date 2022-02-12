<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'user1',
            'email' => 'user1@posbang.com',
            'password' => Hash::make('7ujm&UJM')
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@posbang.com',
            'password' => Hash::make('8ik,*IK<')
        ]);
    }
}
