<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      $title = $this->faker->sentence();
        return [
          'title' => $title,
          'image' => '01JBE46AZG8QKM1CBE8D14K48F.png',
          'duration' => $this->faker->randomDigit(),
          'slug' => Str::slug($title),
          'description' => $this->faker->text(),
          'price' => $this->faker->randomDigit(),
          'luggage' => $this->faker->randomDigit(),
          'passenger' => $this->faker->randomDigit(),
          'car_type' => $this->faker->randomDigit(),
          'isDriver' => $this->faker->boolean(),
        ];
    }
}
