<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'name' => 'Muhammad Tahir Irshad',
            'email' => 'styleofglobal@gmail.com',
            // 'mobile' => '923322184182',
            'password' => Hash::make('smallworldfs')
        ]);
    }
}
