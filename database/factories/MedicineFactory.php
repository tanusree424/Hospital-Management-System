<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Medicine;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Medicine::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'category' => $this->faker->randomElement(['Tablet', 'Capsule', 'Syrup', 'Injection']),
            'stock' => $this->faker->numberBetween(10, 500),
            'manufacturer' => $this->faker->company(),
            'dosage' => $this->faker->numberBetween(100, 1000), // mg
            'expiry_date' => $this->faker->dateTimeBetween('+6 months', '+2 years')->format('Y-m-d'),
            'description' => $this->faker->sentence(8),
        ];
    }
}
