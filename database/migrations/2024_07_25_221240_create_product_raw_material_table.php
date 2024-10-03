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
        Schema::create('product_raw_material', function (Blueprint $table) {
            $table->id();
            $table->string('quantity_of_raw_material');
            $table->foreignId('product_id')->constrained('products', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('raw_material_id')->constrained('raw_materials', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_raw_materials');
    }
};
