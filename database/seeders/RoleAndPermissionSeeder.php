<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Admin']);

        Permission::create(['name' => 'create jabatan']);

        // index
        Permission::create(['name' => 'read jabatan']);

        // edit & update dijadiin satu permission
        Permission::create(['name' => 'edit jabatan']);
        Permission::create(['name' => 'delete jabatan']);

        Permission::create(['name' => 'create status karyawan']);
        Permission::create(['name' => 'read status karyawan']);
        Permission::create(['name' => 'edit status karyawan']);
        Permission::create(['name' => 'delete status karyawan']);

        Permission::create(['name' => 'create divisi']);
        Permission::create(['name' => 'read divisi']);
        Permission::create(['name' => 'edit divisi']);
        Permission::create(['name' => 'delete divisi']);

        Permission::create(['name' => 'create lokasi']);
        Permission::create(['name' => 'read lokasi']);
        Permission::create(['name' => 'edit lokasi']);
        Permission::create(['name' => 'delete lokasi']);

        Permission::create(['name' => 'create category']);
        Permission::create(['name' => 'read category']);
        Permission::create(['name' => 'edit category']);
        Permission::create(['name' => 'delete category']);

        Permission::create(['name' => 'create category request']);
        Permission::create(['name' => 'read category request']);
        Permission::create(['name' => 'edit category request']);
        Permission::create(['name' => 'delete category request']);

        Permission::create(['name' => 'create category potongan']);
        Permission::create(['name' => 'read category potongan']);
        Permission::create(['name' => 'edit category potongan']);
        Permission::create(['name' => 'delete category potongan']);

        Permission::create(['name' => 'create category benefit']);
        Permission::create(['name' => 'read category benefit']);
        Permission::create(['name' => 'edit category benefit']);
        Permission::create(['name' => 'delete category benefit']);

        Permission::create(['name' => 'create unit']);
        Permission::create(['name' => 'read unit']);
        Permission::create(['name' => 'edit unit']);
        Permission::create(['name' => 'delete unit']);

        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'read user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'create supplier']);
        Permission::create(['name' => 'read supplier']);
        Permission::create(['name' => 'edit supplier']);
        Permission::create(['name' => 'delete supplier']);

        Permission::create(['name' => 'create customer']);
        Permission::create(['name' => 'read customer']);
        Permission::create(['name' => 'edit customer']);
        Permission::create(['name' => 'delete customer']);

        Permission::create(['name' => 'create karyawan']);
        Permission::create(['name' => 'read karyawan']);
        Permission::create(['name' => 'edit karyawan']);
        Permission::create(['name' => 'delete karyawan']);

        Permission::create(['name' => 'edit toko']);

        $userAdmin = User::first();
        $userAdmin->assignRole('admin');
        $userAdmin->givePermissionTo(Permission::all());
    }
}
