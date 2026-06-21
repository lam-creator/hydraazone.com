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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('product_slug')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->string('image')->nullable();
            $table->decimal('sale_price', 8, 2)->nullable();
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->text('additional_info')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('show_as', ['general','featured', 'upcoming'])->default('general');
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};