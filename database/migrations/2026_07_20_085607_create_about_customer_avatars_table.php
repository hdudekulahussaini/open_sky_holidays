<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_customer_avatars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('about_section_id')
                ->constrained('about_sections')
                ->cascadeOnDelete();

            $table->string('image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_customer_avatars');
    }
};