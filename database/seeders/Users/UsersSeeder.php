<?php

namespace Database\Seeders\Users;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = [
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'account_role_id' => 3,
            'account_status_id' => 1,
            'gender_id' => 3,
        ];

        User::createOrFirst([
            'name' => $superAdmin['name'],
            'username' => '@superadmin',
            'email' => $superAdmin['email'],
            'password' => bcrypt($superAdmin['password']),
            'account_role_id' => $superAdmin['account_role_id'],
            'account_status_id' => $superAdmin['account_status_id'],
            'gender_id' => $superAdmin['gender_id'],
        ]);

    }
}
