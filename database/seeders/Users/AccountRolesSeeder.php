<?php

namespace Database\Seeders\Users;

use App\Models\Users\AccountRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'users',
            'admin',
            'super_admin',
            'guest'
        ];

        foreach ($roles as $role) {
            AccountRoles::createOrFirst([
                'account_role' => $role
            ]);
        }
    }
}
