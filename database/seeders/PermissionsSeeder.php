<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'category_access',
            'category_create',
            'category_edit',
            'category_show',
            'category_delete',
            'role_access',
            'role_create',
            'role_edit',
            'role_show',
            'role_delete',
            'admin_access',
            'admin_create',
            'admin_edit',
            'admin_show',
            'admin_delete',            
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }
       
    }
}
