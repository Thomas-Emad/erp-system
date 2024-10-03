<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillsSeeder extends Seeder
{
  private $skills = [
    ['name' => 'HTML', 'img' => 'html.png'],
    ['name' => 'CSS', 'img' => 'css.png'],
    ['name' => 'JavaScript', 'img' => 'js.png'],
    ['name' => 'PHP', 'img' => 'php.png'],
    ['name' => 'OOP', 'img' => 'oop.png'],
    ['name' => 'Laravel', 'img' => 'laravel.png'],
    ['name' => 'MySQL', 'img' => 'mysql.png'],
    ['name' => 'Tailwind', 'img' => 'tailwind.png'],
    ['name' => 'Bootstrap', 'img' => 'bootstrap.png'],
    ['name' => 'Git', 'img' => 'git.png'],
    ['name' => 'GitHub', 'img' => 'github.png'],
    ['name' => 'API', 'img' => 'api.png'],
    ['name' => 'Livewire', 'img' => 'livewire.png'],
    ['name' => 'Illustrator', 'img' => 'illustrator.png'],
  ];
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    foreach ($this->skills as $skill) {
      \App\Models\Skill::create($skill);
    }
  }
}
