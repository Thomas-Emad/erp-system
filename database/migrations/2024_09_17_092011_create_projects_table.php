<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('projects', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      $table->string('preview')->nullable();
      $table->string('github')->nullable();
      $table->enum('type', ['personal', 'professional'])->default('personal');
      $table->enum('platform', ['upwork', 'freelancer', 'other'])->nullable();
      $table->date('published_at')->nullable();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('projects');
  }
};
