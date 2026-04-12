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
        $now = Carbon::now();
        $roles = ['Super Administrator', 'Administrator', 'Officer', 'Student'];

        foreach ($roles as $r) {
            DB::table('tbl_roles')->updateOrInsert(
                ['name' => $r],
                ['description' => null, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
