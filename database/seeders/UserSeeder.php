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
                'fname' => 'Jetro',
                'mname' => 'P',
                'lname' => 'Pad-ay',
                'fullname' => 'Jetro P Pad-ay',
                'email' => 'developerdev631@gmail.com',
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
           
        ]);
    }
}
