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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('name', 50);
            $table->decimal('debtor');
            $table->longText('info')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address', 30)->nullable();
            $table->date('brithday')->nullable();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete("no action");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
