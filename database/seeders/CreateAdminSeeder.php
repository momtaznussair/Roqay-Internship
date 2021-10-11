<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creating super admin
        $admin = Admin::create([
            'name' => 'Momtaz Nussair',
            'email' => 'admin@momtaz.com',
            'password' => bcrypt('momtaznussair'),
            ]);

        // creating super admin role
        $role =  Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'admin'
        ]);

        // assign role to admin
        $admin->assignRole($role) ;

        /**  for permissions I've set a global Gate::before rule 
         which checks for 'Super Admin role' check : AuthServiceProvider**/
    }
}
