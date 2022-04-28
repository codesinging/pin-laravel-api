<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WechatUser>
 */
class WechatUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['openid' => "string", 'name' => "string", 'avatar' => "string", 'mobile' => "string", 'status' => "bool"])]
    public function definition(): array
    {
        return [
            'openid' => $this->faker->md5,
            'name' => $this->faker->name(),
            'avatar' => $this->faker->imageUrl(120, 120),
            'mobile' => $this->faker->phoneNumber(),
            'status' => $this->faker->boolean(80),
        ];
    }
}
