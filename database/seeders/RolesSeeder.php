<?php

namespace Database\Seeders;

use App\Models\Admin\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Role::factory()->create([
             'role_name' => 'Admin',
             'status' => 1,
         ]);
         Role::factory()->create([
             'role_name' => 'Executive',
             'status' => 1,
         ]);
         Role::factory()->create([
             'role_name' => 'Test User',
             'status' => 1,
         ]);
    }
}
