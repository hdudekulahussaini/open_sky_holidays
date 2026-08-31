<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('about_title')->nullable();
            $table->longText('about_description')->nullable();
            $table->string('about_image')->nullable();

            $table->json('features')->nullable();
            $table->json('service_items')->nullable();
            $table->json('process_steps')->nullable();
            $table->json('documents')->nullable();
            $table->json('why_choose_items')->nullable();

            $table->string('cta_title')->nullable();
            $table->text('cta_description')->nullable();
            $table->string('cta_background_image')->nullable();
            $table->json('stats')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
