<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'column_name' => 'is_employee',
            'role_id' => 0,
            'role_name' => 'Sale Agent',
         ]);
        DB::table('role')->insert([
            'column_name' => 'is_employee',
            'role_id' => 1,
            'role_name' => 'Production Team Lead',
        ]);
        DB::table('role')->insert([
            'column_name' => 'is_employee',
            'role_id' => 2,
            'role_name' => 'Admin',
        ]);
        DB::table('role')->insert([
            'column_name' => 'is_employee',
            'role_id' => 3,
            'role_name' => 'Customer',
        ]);
        DB::table('role')->insert([
            'column_name' => 'is_employee',
            'role_id' => 4,
            'role_name' => 'Customer Support',
        ]);
        DB::table('role')->insert([
            'column_name' => 'is_employee',
            'role_id' => 5,
            'role_name' => 'Production Member',
        ]);
        DB::table('role')->insert([
            'column_name' => 'is_employee',
            'role_id' => 6,
            'role_name' => 'Sales Manager',
        ]);
    }
}
