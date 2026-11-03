<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Client;
use App\Models\Country;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class
UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'email' => 'test@example.com',
        ]);
        $user->assignRole(RoleEnum::ADMIN);
    }
}
