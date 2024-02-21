<?php

namespace Database\Seeders;

use App\Models\Play;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Play::factory(20)->create(); // Crea 20 juegos usando la factory PlayFactory

    }
}
