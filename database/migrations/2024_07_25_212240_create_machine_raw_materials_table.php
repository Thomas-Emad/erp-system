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
    Schema::create('machine_raw_materials', function (Blueprint $table) {
      $table->id();
      $table->foreignId('machine_id')->constrained('machines', 'id')->cascadeOnDelete()->cascadeOnUpdate();
      $table->foreignId('raw_material_id')->constrained('raw_materials', 'id')->cascadeOnDelete()->cascadeOnUpdate();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('machine_raw_materials');
  }
};
