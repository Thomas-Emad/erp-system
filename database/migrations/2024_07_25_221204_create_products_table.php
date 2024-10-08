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
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('description');
      $table->decimal('selling_price');
      $table->decimal('cost_price');
      $table->decimal('profit');
      $table->decimal('price_installment');
      $table->integer('quantity')->default(0);
      $table->text('image');
      $table->boolean('is_expire')->default(0);
      $table->date('expire_date');
      $table->foreignId('machine_id')->constrained('machines', 'id')->cascadeOnDelete()->cascadeOnUpdate();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('products');
  }
};
