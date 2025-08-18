<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AutoChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ['auto charge'];
        foreach ($permissions as $value) {
            Permission::create([
                'name' => $value
            ]);
        }
    }
}
