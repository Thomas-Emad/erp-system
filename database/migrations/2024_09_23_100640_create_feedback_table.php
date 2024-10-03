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
    Schema::create('feedback', function (Blueprint $table) {
      $table->id();
      $table->string('name', 50);
      $table->string('email')->nullable();
      $table->text('message');
      $table->string('link');
      $table->enum('platform', ['upwork', 'freelancer', 'other'])->default('other');
      $table->date('published_at')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('feedback');
  }
};
