<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offer_banners', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('discount_text', 100);
            $table->string('subtitle');
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offer_banners');
    }
};