<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dmin = Admin::create([
            'name' => 'Momtaz Nussair',
            'email' => 'admin@momtaz.com',
            'password' => bcrypt('momtaznussair'),
            ]);
    }
}
