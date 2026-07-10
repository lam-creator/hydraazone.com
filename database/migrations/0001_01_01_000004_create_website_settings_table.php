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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_slogan')->nullable();
            $table->string('phone')->nullable();
            $table->string('support_phone')->nullable();
            $table->string('email')->nullable();
            $table->text('company_address')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('android_app_url')->nullable();
            $table->string('ios_app_url')->nullable();
            $table->text('copyright')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            // custom code in header and footer for large data like google analytics, facebook pixel, etc.
            $table->longText('custom_code_header')->nullable();
            $table->longText('custom_code_footer')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};