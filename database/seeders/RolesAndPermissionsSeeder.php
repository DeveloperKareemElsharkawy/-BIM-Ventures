<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete admins', 'guard_name' => 'admin']);



        Permission::create(['name' => 'view transactions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create transactions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit transactions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete transactions', 'guard_name' => 'admin']);


        Permission::create(['name' => 'view payments', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create payments', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit payments', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete payments', 'guard_name' => 'admin']);

        Role::create(['name' => 'super-admin', 'guard_name' => 'admin'])->givePermissionTo(Permission::all());

        Role::create(['name' => 'admin', 'guard_name' => 'admin'])->givePermissionTo(Permission::all());

    }
}
