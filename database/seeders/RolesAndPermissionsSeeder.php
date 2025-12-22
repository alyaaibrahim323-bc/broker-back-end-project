<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
{
    $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
    $admin = Role::firstOrCreate(['name' => 'admin']);
    $user = Role::firstOrCreate(['name' => 'user']);

    Permission::firstOrCreate(['name' => 'manage users']);
    Permission::firstOrCreate(['name' => 'manage units']);
    Permission::firstOrCreate(['name' => 'view dashboard']);
    Permission::firstOrCreate(['name' => 'manage admins']);

    $superAdmin->givePermissionTo(['manage users', 'manage units', 'view dashboard', 'manage admins']);
    $admin->givePermissionTo(['manage units', 'view dashboard']);
    $user->givePermissionTo([]);
}
}
