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
            $table->string('date')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('zone')->nullable();
            $table->string('address')->nullable();
            $table->string('order_note')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('shipping', 10, 2)->default(0.00);
            $table->enum('status',['processing','approved','delivered','cancelled'])->default('processing');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
