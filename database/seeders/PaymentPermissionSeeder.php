<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PaymentPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ['view payment','create payment', 'edit payment', 'delete payment'];
        foreach ($permissions as $value) {
            Permission::create([
                'name' => $value
            ]);
        }
    }
}
