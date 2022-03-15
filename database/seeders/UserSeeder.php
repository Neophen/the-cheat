<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  use WithoutModelEvents;

  public function run(): void
  {
    User::create([
      'name' => 'Mykolas',
      'email' => 'mykolas@the-cheat.com',
      'email_verified_at' => now(),
      'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
      'role' => 'admin',
      'remember_token' => Str::random(10),
    ]);

    User::factory(10)->create();
  }
}
