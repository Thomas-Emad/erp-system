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
        Schema::create('selling_invoice_products', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity'); 
            $table->decimal('price'); 
            $table->foreignId('store_id')->constrained('stores', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('product_id')->constrained('products', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('selling_invoice_id')->constrained('selling_invoices', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selling_invoice_products');
    }
};
