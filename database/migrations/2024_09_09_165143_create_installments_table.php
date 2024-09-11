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
    Schema::create('installments', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('client_id');
      $table->string('attachment')->nullable();
      $table->decimal('total_installment', 10, 2)->default(0);
      $table->decimal('installment_amount', 10, 2)->default(0);
      $table->date("start");
      $table->date("end")->nullable();
      $table->enum("duration", ['week', 'month', 'year'])->default('month');
      $table->decimal("credit_balance", 10, 2)->default(0);
      $table->enum('status', ['open', 'paid', 'closed'])->default('open');
      $table->enum('type', ['customer', 'supplier'])->default('customer');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('installments');
  }
};
