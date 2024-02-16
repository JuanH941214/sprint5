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

      /**
     * admin debe 
     * -poder ver todos los jugadores 
     * -ver promedio de exito por jugador
     * -ver promedio de exito de todos los jugadores 
     * 
     * el jugador :
     * -jugar 
     * -ver su lista de resultados 
     * -elmintar toda su lista de resultaods 
     * -ver su porcentaje de exito
     */
    public function run(): void
    {
        $rolAdmin=Role::create(['name'=>'admin', 'guard_name' => 'api']);
        $rolPlayer=Role::create(['name'=>'player', 'guard_name' => 'api']);

        Permission::create(['name' => 'admin.seeAllPlayers'])->assignRole($rolAdmin);
        Permission::create(['name' => 'admin.PlayerWinRate'])->assignRole($rolAdmin);
        Permission::create(['name' => 'admin.allWinRates'])->assignRole($rolAdmin);


        Permission::create(['name' => 'player.play'])->assignRole($rolPlayer);
        Permission::create(['name' => 'player.seeResults'])->assignRole($rolPlayer);
        Permission::create(['name' => 'player.deleteResults'])->assignRole($rolPlayer);
        Permission::create(['name' => 'player.seeWinRate'])->assignRole($rolPlayer);




    }
}
