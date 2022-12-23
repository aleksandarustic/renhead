<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'type' => fake()->randomElement(['APPROVER', "NON_APPROVER"]),
            'password' => 'password',
            'remember_token' => Str::random(10),
        ];
    }

    public function approver()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'APPROVER',
            ];
        });
    }


    public function nonApprover()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'NON_APPROVER',
            ];
        });
    }
}
