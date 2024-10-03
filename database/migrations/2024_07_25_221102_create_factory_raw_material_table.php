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
        Schema::create('factory_raw_material', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->foreignId('factory_id')->constrained('factories', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('raw_material_id')->constrained('raw_materials', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factory_raw_materials');
    }
};
