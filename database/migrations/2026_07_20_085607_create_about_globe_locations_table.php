<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_globe_locations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('about_section_id')
                ->constrained('about_sections')
                ->cascadeOnDelete();

            $table->string('location_name');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('destination_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_globe_locations');
    }
};