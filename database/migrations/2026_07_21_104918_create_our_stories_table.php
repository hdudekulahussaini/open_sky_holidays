<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('our_stories', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->longText('description')->nullable();
            $table->json('images')->nullable();

            /*
             * Example:
             * [
             *     {
             *         "heading": "Our Mission",
             *         "sub_heading": "Providing memorable travel experiences"
             *     }
             * ]
             */
            $table->json('features')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('our_stories');
    }
};
