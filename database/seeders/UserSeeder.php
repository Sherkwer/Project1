<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'fname' => 'John',
                'mname' => 'A',
                'lname' => 'Doe',
                'fullname' => 'John A Doe',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
                'user_role' => 1,
                'area_code' => '001',
                'department_id' => 1,
                'organization_id' => 1,
                'is_approved' => 1,
                'is_admin' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fname' => 'Maria',
                'mname' => 'B',
                'lname' => 'Santos',
                'fullname' => 'Maria B Santos',
                'email' => 'officer@example.com',
                'password' => Hash::make('12345678'),
                'user_role' => 2,
                'area_code' => '002',
                'department_id' => 1,
                'organization_id' => 1,
                'is_approved' => 1,
                'is_admin' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fname' => 'Juan',
                'mname' => 'C',
                'lname' => 'Dela Cruz',
                'fullname' => 'Juan C Dela Cruz',
                'email' => 'student@example.com',
                'password' => Hash::make('12345678'),
                'user_role' => 3,
                'area_code' => '003',
                'department_id' => 1,
                'organization_id' => 1,
                'is_approved' => 1,
                'is_admin' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
