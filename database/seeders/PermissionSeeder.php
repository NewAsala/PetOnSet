<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'products.view',
            'products.create',
            'products.update',
            'products.delete',

            'customers.view',
            'customers.create',
            'customers.update',
            'customers.delete',

            'pets.view',
            'pets.create',
            'pets.update',
            'pets.delete',

            'appointments.view',
            'appointments.create',
            'appointments.update',
            'appointments.delete',

            'inventory.view',
            'inventory.manage',

            'returns.view',
            'returns.create',
            'returns.approve',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
