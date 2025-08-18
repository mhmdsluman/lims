<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uhid' => 'HMS-A' . Str::random(7),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'primary_phone_country_code' => '+1',
            'primary_phone' => $this->faker->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail,
            'addresses' => [
                [
                    'type' => 'Home',
                    'street' => $this->faker->streetAddress,
                    'city' => $this->faker->city,
                    'state' => $this->faker->stateAbbr,
                    'postal_code' => $this->faker->postcode,
                    'country' => 'USA',
                ],
            ],
        ];
    }
}
