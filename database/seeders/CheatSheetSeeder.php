<?php

namespace Database\Seeders;

use App\Models\CheatSheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CheatSheetSeeder extends Seeder
{
  use WithoutModelEvents;

  public function run(): void
  {
    CheatSheet::factory(100)->create();
  }
}
