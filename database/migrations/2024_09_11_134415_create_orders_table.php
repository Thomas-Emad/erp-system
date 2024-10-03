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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_cost')->default(0);
            $table->decimal('shipping_price')->default(0);
            $table->date('time');
            $table->enum('status', ['waiting', 'working', 'delivered'])->default('waiting');
            // المخزن اللي هيروح فيه المنتجات بعد تصنيعها
            $table->foreignId('store_id')->constrained('stores', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            // المصنع اللي مطلوب منه التصنيع
            $table->foreignId('factory_id')->constrained('factories', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
