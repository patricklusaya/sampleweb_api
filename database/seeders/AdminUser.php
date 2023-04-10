<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
            'username' => 'admin',
            'email' => 'admin@jf.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            ]
            );
    }
}
