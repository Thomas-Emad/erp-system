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
        Schema::create('buying_invoice_raw_materials', function (Blueprint $table) {
            $table->id(); 
            $table->integer('quantity'); 
            $table->decimal('price'); 
            $table->foreignId('raw_material_id')->constrained('raw_materials', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('buying_invoice_id')->constrained('buying_invoices', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buying_invoice_raw_materials');
    }
};
