<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $admin = Role::findByName('admin', 'web');

        $admin->syncPermissions([
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
        ]);


        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */

        $manager = Role::findByName('manager', 'web');

        $manager->syncPermissions([
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
        ]);


        /*
        |--------------------------------------------------------------------------
        | Cashier
        |--------------------------------------------------------------------------
        */

        $cashier = Role::findByName('cashier', 'web');

        $cashier->syncPermissions([
            'products.view',

            'customers.view',
            'customers.create',
            'customers.update',

            'pets.view',
            'pets.create',
            'pets.update',

            'appointments.view',
            'appointments.create',
            'appointments.update',

            'inventory.view',

            'returns.view',
            'returns.create',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Groomer
        |--------------------------------------------------------------------------
        */

        $groomer = Role::findByName('groomer', 'web');

        $groomer->syncPermissions([
            'pets.view',
            'pets.update',

            'appointments.view',
            'appointments.update',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Inventory Manager
        |--------------------------------------------------------------------------
        */

        $inventoryManager = Role::findByName(
            'inventory_manager',
            'web'
        );

        $inventoryManager->syncPermissions([
            'products.view',
            'products.create',
            'products.update',

            'inventory.view',
            'inventory.manage',

            'returns.view',
            'returns.create',
        ]);
    }
}
