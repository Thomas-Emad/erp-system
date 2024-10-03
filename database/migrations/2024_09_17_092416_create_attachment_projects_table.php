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
    Schema::create('attachment_projects', function (Blueprint $table) {
      $table->id();
      $table->foreignId('project_id')->constrained()->cascadeOnDelete();
      $table->string('attachment');
      $table->string('name')->nullable();
      $table->boolean('banner')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('attachment_projects');
  }
};
