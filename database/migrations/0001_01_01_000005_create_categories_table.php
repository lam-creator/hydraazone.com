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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
			$table->string('name')->unique()->nullable();
            $table->string('category_slug')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->enum('show_in_homepage',['active','inactive'])->default('inactive');
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
