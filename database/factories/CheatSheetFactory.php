<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CheatSheet>
 */
class CheatSheetFactory extends Factory
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
      'description' => $this->faker->realTextBetween(160, 300),
      'img' => null,
      'approved' => false,
      'is_public' => true,
      'user_id' => User::factory(),
    ];
  }
}
