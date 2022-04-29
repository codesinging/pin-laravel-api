<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'key' => $this->faker->unique()->word,
            'value' => $this->faker->randomElement([
                $this->faker->word,
                $this->faker->boolean(),
                $this->faker->name,
                $this->faker->randomNumber(),
                $this->faker->randomFloat(),
                $this->faker->date(),
                $this->faker->dateTime(),
                $this->faker->city(),
                $this->faker->postcode(),
                $this->faker->rgbColorAsArray(),
            ]),
        ];
    }
}
