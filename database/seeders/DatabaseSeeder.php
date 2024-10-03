<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      SkillsSeeder::class
    ]);

    User::factory()->create([
      'name' => 'Thomas Emad',
      'email' => 'tomtom22006@gmail.com',
      'password' => Hash::make('28896740')
    ]);
  }
}
