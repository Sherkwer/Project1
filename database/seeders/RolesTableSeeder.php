<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('tbl_roles')->insert([
            ['id' => 1],
                [
                    'name' => 'Administrator',
                    'description' => 'Full system access',
                    'updated_at' => now(),
                ],
            ['id' => 2],
                [
                    'name' => 'Officer',
                    'description' => 'Manages records and operations',
                    'updated_at' => now(),
                ],
            ['id' => 3],
                [
                    'name' => 'Student',
                    'description' => 'Regular user access',
                    'updated_at' => now(),
                ],
            ['id' => 4],
                [
                    'name' => 'Super Administrator',
                    'description' => 'System owner with full privileges',
                    'updated_at' => now(),
                ],                             
        ]);
    }
}
