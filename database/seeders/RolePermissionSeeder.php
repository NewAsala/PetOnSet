<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\RoleEnum;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $admin = Role::findByName(RoleEnum::ADMIN, 'web');

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

        $manager = Role::findByName(RoleEnum::MANAGER, 'web');

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

        $cashier = Role::findByName(RoleEnum::CASHIER, 'web');

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

        $groomer = Role::findByName(RoleEnum::GROOMER, 'web');

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
            RoleEnum::INVENTORY_MANAGER,
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

        $inventoryManager = Role::findByName(
            RoleEnum::EMPLOYEE,
            'web'
        );

        $inventoryManager->syncPermissions([
            'products.view',
        ]);
    }
}
