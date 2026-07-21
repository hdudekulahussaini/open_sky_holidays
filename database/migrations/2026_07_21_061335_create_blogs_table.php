<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('author_id')
                ->nullable()
                ->constrained('authors')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->text('short_description');
            $table->longText('content');

            $table->string('featured_image')->nullable();

            $table->unsignedInteger('read_time')->default(5);

            $table->boolean('status')
                ->default(false)
                ->index();

            $table->timestamp('published_at')
                ->nullable()
                ->index();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
