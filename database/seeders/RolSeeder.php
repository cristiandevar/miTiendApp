<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol_admin = Role::create(['name' => 'admin']);
        $rol_seller = Role::create(['name' => 'seller']);
        $rol_boss = Role::create(['name' => 'boss']);

        Permission::create(['name' => 'func_admin'])->assignRole($rol_admin);
        Permission::create(['name' => 'func_seller'])->assignRole($rol_seller);
        Permission::create(['name' => 'func_boss'])->assignRole($rol_boss);
    }
}
