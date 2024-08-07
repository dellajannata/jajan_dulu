<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password'=> Hash::make('admin'),
                'role' => 'admin'
            ]
        ];
        User::insert($user);
    }
}