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
        Schema::create('tour_features', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')
                ->constrained('tours')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->enum('type', [
                'package_inclusion',
                'place_covered',
                'tour_highlight',
            ]);

            $table->string('title');

            $table->text('description')->nullable();

            /*
             * Used mainly for places covered.
             */
            $table->string('image')->nullable();

            /*
             * Used for package inclusions and highlights.
             * Store a selected icon name or icon class.
             */
            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();

            $table->index([
                'tour_id',
                'type',
                'status',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_features');
    }
};
