<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nickname' => 'Juan Hernandez',
            'email' => 'juanHernandez@gmail.com',
            'password'=> Hash::make('password')
        ]);
        User::create([
            'nickname' => 'Joan clement',
            'email' => 'joancl@gmail.com',
            'password'=> Hash::make('password')
        ])->assignRole('admin');
        User::create([
            'nickname' => 'Andrea lucia',
            'email' => 'andLul@gmail.com',
            'password'=> Hash::make('password')
        ])->assignRole('player');
        User::create([
            'nickname' => 'Nicolas Casto',
            'email' => 'Nical@gmail.com',
            'password'=> Hash::make('password')
        ])->assignRole('player');
    }
}
