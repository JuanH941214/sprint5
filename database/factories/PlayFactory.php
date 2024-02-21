<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\Database\Factories\UserFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Play>
 */
class PlayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $diceOne = fake()->numberBetween(1, 6);
        $diceTwo = fake()->numberBetween(1, 6);
        return [
            'diceOne' => $diceOne,
            'diceTwo' => $diceTwo,
            'sum' =>  $diceOne + $diceTwo,
            'user_id' => User::factory(),
        ];
    }
}
