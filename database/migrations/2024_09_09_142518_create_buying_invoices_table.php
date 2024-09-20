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
    Schema::create('buying_invoices', function (Blueprint $table) {
      $table->id();
      $table->enum('status', ['cash', 'offer_price', 'agel', 'paid', 'closed'])->default('cash');
      $table->decimal('total_price')->default(0);
      $table->foreignId('factory_id')->constrained('factories', 'id')->cascadeOnDelete()->cascadeOnUpdate();
      $table->foreignId('supplier_id')->constrained('suppliers', 'id')->cascadeOnDelete()->cascadeOnUpdate();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('buying_invoices');
  }
};
