<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudentsManagementModel;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'fullname' => 'Test User',
            'email' => 'test@example.com',
        ]);

        StudentsManagementModel::factory()->count(50)->create();
    }
}
