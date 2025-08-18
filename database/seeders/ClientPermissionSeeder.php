<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ClientPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ['view client','create client', 'edit client', 'delete client', 'logo form'];
        foreach ($permissions as $value) {
            Permission::create([
                'name' => $value
            ]);
        }
    }
}
