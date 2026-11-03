<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\RoleEnum;

use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            RoleEnum::ADMIN,
            RoleEnum::MANAGER,
            RoleEnum::CASHIER,
            RoleEnum::GROOMER,
            RoleEnum::INVENTORY_MANAGER,
            RoleEnum::EMPLOYEE,
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }
    }
}
