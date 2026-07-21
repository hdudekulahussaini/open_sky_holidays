<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_support_sections', function (Blueprint $table) {
            $table->id();

            $table->string('small_heading')->nullable();
            $table->string('heading');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->json('features')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_support_sections');
    }
};
