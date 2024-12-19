<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
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
          'slug' => Str::slug($title),
          'price' => $this->faker->randomFloat(2, 10),
          'duration' => $this->faker->randomFloat(2, 10),
          'description' => $this->faker->text(),
          'image' => 'istockphoto-1287177215-612x612.jpg',
        ];
    }
}
