<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Play;
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
    protected $model = Play::class;
    public function definition(): array
    {
        $diceOne = fake()->numberBetween(1, 6);
        $diceTwo = fake()->numberBetween(1, 6);
        $userId = User::inRandomOrder()->first()->id;

        return [
            'diceOne' => $diceOne,
            'diceTwo' => $diceTwo,
            'result' =>  $diceOne + $diceTwo,
            //'user_id' => User::factory(), duplica usarios ?
            'user_id' => $userId,
        ];
    }
}
