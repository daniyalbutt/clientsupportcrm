<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class BrandPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ['view brand','create brand', 'edit brand', 'delete brand'];
        foreach ($permissions as $value) {
            Permission::create([
                'name' => $value
            ]);
        }
    }
}
