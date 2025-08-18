<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class InvoiceDownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ['download invoice'];
        foreach ($permissions as $value) {
            Permission::create([
                'name' => $value
            ]);
        }
    }
}
