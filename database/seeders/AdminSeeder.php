<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $superAdmin = Admin::query()->firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'mobile' => '0123456789',
                'password' => '123456789',
            ]
        );

        $superAdmin->assignRole(RoleEnum::SuperAdmin);

        Admin::factory(10)->create();
    }
}
