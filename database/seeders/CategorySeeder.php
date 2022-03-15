<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  use WithoutModelEvents;

  public function run(): void
  {
    Category::factory(20)->create();
  }
}
