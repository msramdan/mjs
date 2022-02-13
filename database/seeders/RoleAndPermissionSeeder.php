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
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleGm =  Role::create(['name' => 'gm']);
        $roleDirektur = Role::create(['name' => 'direktur']);

        foreach (config('permission.list_permissions') as $permission) {
            foreach ($permission['lists'] as $list) {
                Permission::create(['name' => $list]);
            }
        }

        $userAdmin = User::first();
        $userAdmin->assignRole('admin');
        $roleAdmin->givePermissionTo(Permission::all());

        $userGm = User::find(2);
        $userGm->assignRole('gm');
        $roleGm->givePermissionTo([
            'view purchase',
            'approve purchase',
            'view request form purchase',
            'edit request form purchase',
        ]);

        $userDirektur = User::find(3);
        $userDirektur->assignRole('direktur');
        $roleDirektur->givePermissionTo([
            'view purchase',
            'approve purchase',
            'view request form purchase',
            'edit request form purchase',
        ]);
    }
}
