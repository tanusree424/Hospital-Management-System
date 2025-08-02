<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bed;
use App\Models\Ward;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bed>
 */
class BedFactory extends Factory
{
     protected $model = Bed::class;

    public function definition(): array
    {

       return [
            'ward_id' => Ward::inRandomOrder()->first()->id ?? 1, // Default to ward_id=1 if no ward exists
            'bed_number' => $this->faker->unique()->numberBetween(100, 999),
            'status' => $this->faker->randomElement(['Available', 'Occupied', 'Maintenance']),
            'description' => $this->faker->sentence(),
        ];
    }
}
