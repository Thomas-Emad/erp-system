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
    Schema::create('machine_factories', function (Blueprint $table) {
      $table->id();
      $table->integer('quantity');
      $table->foreignId('machine_id')->constrained('machines', 'id')->cascadeOnDelete()->cascadeOnUpdate();
      $table->foreignId('factory_id')->constrained('factories', 'id')->cascadeOnDelete()->cascadeOnUpdate();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('machine_factories');
  }
};
