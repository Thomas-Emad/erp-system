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
    Schema::create('installment_products', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('installment_id');
      $table->unsignedBigInteger('product_id');
      $table->decimal("price", 10, 2);
      $table->integer("quantity");
      $table->timestamps();

      $table->foreign('installment_id')->references('id')->on('installments')->cascadeOnDelete()->cascadeOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('installment_products');
  }
};
