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
        Schema::create('top_headers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable()->default('info@openskyholidays.com');
            $table->text('tagline')->nullable()->default('The World Is Waiting. One Stop Destination For All Your Tours & Travels Needs.');
            $table->string('button_text')->nullable()->default('Book Your Tour');
            $table->string('button_url')->nullable()->default('#');
            $table->json('social_links')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_headers');
    }
};
