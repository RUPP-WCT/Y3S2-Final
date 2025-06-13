<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Users\AccountRolesSeeder;
use Database\Seeders\Users\AccountStatusesSeeder;
use Database\Seeders\Users\GendersSeeder;
use Database\Seeders\Users\UsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AccountStatusesSeeder::class,
            AccountRolesSeeder::class,
            GendersSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
