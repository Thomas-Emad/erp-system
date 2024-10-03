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
    Schema::create('transactions', function (Blueprint $table) {
      $table->id();
      $table->string('title', 50)->nullable();
      $table->unsignedBigInteger('owner_id')->nullable();
      $table->unsignedBigInteger('client_id')->nullable();
      $table->string('description', 255)->nullable();
      $table->decimal('amount', 10, 2);
      $table->enum('client_type', ['employee', 'supplier', 'customer'])->default('employee');
      $table->enum('transaction_type', ['withdraw', 'deposit'])->default('withdraw');
      $table->enum('transaction_category', ['salary', 'pay_installment', 'receive_installment', 'cash', 'other'])->default('other');
      $table->string('attachment')->nullable();
      $table->timestamps();

      $table->foreign('owner_id')->references('id')->on('users')->noActionOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('transactions');
  }
};
