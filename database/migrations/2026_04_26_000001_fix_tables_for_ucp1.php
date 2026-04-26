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
        // Drop existing tables to follow PDF schema exactly
        Schema::dropIfExists('kategoris');
        Schema::dropIfExists('products');

        // Create category table (singular as per PDF)
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Create product table (singular as per PDF)
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('quantity');
            $table->decimal('price', 10, 2);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('category')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
        Schema::dropIfExists('category');
    }
};
