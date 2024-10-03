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
    Schema::create('installment_payments', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('installment_id');
      $table->decimal("amount", 10, 2);
      $table->string("attachment")->nullable();
      $table->date("date");
      $table->enum('status', ['unpaid', 'paid', 'closed'])->default('unpaid');
      $table->enum('type', ['customer', 'supplier'])->default('customer');
      $table->timestamps();

      $table->foreign('installment_id')->references('id')->on('installments')->cascadeOnDelete()->cascadeOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('installment_payments');
  }
};
