<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolAdmin=Role::create(['name'=>'admin']);
        $rolPlayer=Role::create(['name'=>'player']);

        Permission:create(['name' => 'admin.winRate'])->assignRole($rolAdmin);

    }
}
