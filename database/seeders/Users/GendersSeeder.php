<?php

namespace Database\Seeders\Users;

use App\Models\Users\Genders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GendersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = [
            'male',
            'female',
            'rather not say',
            'other'
        ];

        foreach ($genders as $gender) {
            Genders::createOrFirst([
                'gender' => $gender
            ]);
        };
    }
}
