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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("worker_id");
            $table->time('presence')->default(now());
            $table->time('departure')->nullable();
            $table->date('day')->default(now()->format('Y-m-d'));
            $table->timestamps();

            $table->foreign('worker_id')->references('id')->on("users")->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
