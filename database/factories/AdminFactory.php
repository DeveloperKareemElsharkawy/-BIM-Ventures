<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $phoneDigits = $this->faker->numerify('###########'); // Adjust the number of #'s as needed

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'mobile' => $phoneDigits, // Generate a random phone number
            'password' => '123456789',
            'remember_token' => Str::random(10),
        ];
    }


    public function configure()
    {
        return $this->afterCreating(function (Admin $admin) {
            // Assign a role to the created admin
            $admin->assignRole(RoleEnum::Admin);
        });
    }
}
