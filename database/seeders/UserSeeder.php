<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create(
            [
                'nama' => 'Mas Admin',
                'username' => 'admin',
                'password' => bcrypt(12345),
                'level' => 'admin',                   
            ]
            );
    }
}
