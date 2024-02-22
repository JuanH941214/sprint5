<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Play;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder


{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $userController = new UserController();
        User::factory(10)->create()->each(function ($user) use ($userController){
            $user->assignRole('player');
            Play::factory(['user_id' => $user->id])->count(rand(1, 5))->create();
            $winRate=$userController->calculateWinrate($user->id); 

        });

/*
        User::all()->each(function($user) use ($userController){
            $winRate=$userController->calculateWinrate($user->id);    
        })
        
       // $admin=User::factory()->create();
       // $admin->assignRole('admin');*/

        User::create([
            'nick_name' => 'Joan clement',
            'email' => 'joancl@gmail.com',
            'password'=> Hash::make('password'),            
        ])->assignRole('admin');
    }

    
}
