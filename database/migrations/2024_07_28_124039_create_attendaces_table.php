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
        Schema::create('attendaces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("admin_id");
            $table->unsignedBigInteger("worker_id");
            $table->dateTime('presence')->default(now());
            $table->dateTime('departure')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on("users")->noActionOnDelete();
            $table->foreign('worker_id')->references('id')->on("users")->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendaces');
    }
};
