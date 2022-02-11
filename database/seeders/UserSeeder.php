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
            'name' => 'robert',
            'email' => 'hi@posbang.com',
            'password' => Hash::make('7ujm&UJM')
        ]);
    }
}
