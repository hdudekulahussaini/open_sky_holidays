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
        Schema::create('tour_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')
                ->constrained('tours')
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->date('travel_date');
            $table->integer('travelers');
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_inquiries');
    }
};
