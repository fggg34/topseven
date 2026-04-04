<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hotel>
 */
class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company().' '.fake()->randomElement(['Hotel', 'Resort', 'Suites']),
            'classification' => fake()->randomElement([Hotel::CLASSIFICATION_HOTEL, Hotel::CLASSIFICATION_RESORT]),
            'is_active' => true,
        ];
    }
}
