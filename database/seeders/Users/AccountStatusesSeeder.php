<?php

namespace Database\Seeders\Users;

use App\Models\Users\AccountStatuses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'active',
            'pending',
            'inactive',
            'banned',
            'suspended'
        ];

        foreach ($statuses as $status) {
            AccountStatuses::createOrFirst([
                'account_status' => $status
            ]);
        }
    }
}
