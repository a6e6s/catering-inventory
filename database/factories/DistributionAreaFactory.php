<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DistributionAreaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $locations = [
            'King Fahd District, Riyadh',
            'Al Olaya, Riyadh',
            'Al Malaz, Riyadh',
            'Al Hamra, Jeddah',
            'Al Shatie, Jeddah',
            'Al Faisaliyah, Dammam',
        ];

        return [
            'name' => fake()->company() . ' Center', // e.g. "Smith Ltd Center" -> "Al-Rahma Center" logic if using Arabic faker later
            'slug' => fake()->slug(),
            'location' => fake()->randomElement($locations) . ', Street ' . fake()->buildingNumber(),
            'contact_person' => fake()->name(),
            'contact_phone' => '+966 5' . fake()->numberBetween(0, 9) . ' ' . fake()->numerify('### ####'),
            'capacity' => fake()->numberBetween(50, 500),
            'distribution_frequency' => fake()->randomElement(array_keys(\App\Models\DistributionArea::FREQUENCIES)),
            'requires_photo_verification' => fake()->boolean(90),
            'is_active' => fake()->boolean(90),
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }
}
