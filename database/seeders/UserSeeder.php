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
                'id' => 1,
                'fname' => 'John',
                'mname' => 'A',
                'lname' => 'Doe',
                'fullname' => 'John A Doe',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'user_role' => 1, // Administrator
                'area_code' => '001',
                'department_id' => 1,
                'organization_id' => 1,
                'is_approved' => 1,
                'is_admin' => 1,
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
                'activated_at' => Carbon::now(),
                'last_login' => null,
                'verification_code' => null,
                'verification_created_at' => null,
                'password_reset_at' => null,
                'created_user_id' => null,
                'deleted_user_id' => null,
                'activated_user_id' => null,
            ],
            [
                'id' => 2,
                'fname' => 'Maria',
                'mname' => 'B',
                'lname' => 'Santos',
                'fullname' => 'Maria B Santos',
                'email' => 'officer@example.com',
                'password' => Hash::make('password123'),
                'user_role' => 2,
                'area_code' => '002',
                'department_id' => 2,
                'organization_id' => 1,
                'is_approved' => 1,
                'is_admin' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'fname' => 'Juan',
                'mname' => 'C',
                'lname' => 'Dela Cruz',
                'fullname' => 'Juan C Dela Cruz',
                'email' => 'student@example.com',
                'password' => Hash::make('password123'),
                'user_role' => 3,
                'area_code' => '003',
                'department_id' => 3,
                'organization_id' => 1,
                'is_approved' => 1,
                'is_admin' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
