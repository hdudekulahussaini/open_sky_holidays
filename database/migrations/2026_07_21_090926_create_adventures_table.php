<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adventures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('adventure_category_id')
                ->unique()
                ->constrained('adventure_categories')
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('description')
                ->nullable();

            $table->json('features')
                ->nullable();

            $table->string('video_link')
                ->nullable();

            $table->string('image_one')
                ->nullable();

            $table->string('image_two')
                ->nullable();

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adventures');
    }
};