<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'title' => $this->faker->name(),
      'slug' => $this->faker->slug(),
      'color' => $this->faker->hexColor(),
      'approved' => false,
      'user_id' => User::factory(),
    ];
  }
}
