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
    Schema::create('salaries', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('owner_id');
      $table->unsignedBigInteger('employee_id');
      $table->decimal('amount', 10, 2);
      $table->string('description', 255)->nullable();
      $table->string('attachment')->nullable();

      $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('salaries');
  }
};
