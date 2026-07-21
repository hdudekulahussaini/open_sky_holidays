<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();

            $table->enum('platform', [
                'tripadvisor',
                'facebook',
                'google',
            ]);

            $table->string('customer_name');
            $table->string('customer_image')->nullable();
            $table->string('location')->nullable();

            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('review');

            $table->dateTime('reviewed_at');
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};