<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        $rows = [
            [
                'name'           =>  'Min Thant Oo',
                'usertype'       =>  '1',
                'email'          =>  'minthantoo.ardil@gmail.com',
                'email_verified_at' => now(),
                'password'       => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'phone'          =>  '05523365717',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        User::insert($rows);
    }
}
