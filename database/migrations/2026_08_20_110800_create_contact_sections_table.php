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
        Schema::create('contact_sections', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable()->default('+91 99081 17712');
            $table->string('email')->nullable()->default('info@openskyholidays.com');
            $table->text('address')->nullable()->default('#1-11-110, Shyamlal Building, Begumpet, Hyderabad - 500018');
            $table->text('map_link')->nullable()->default('https://www.google.com/maps/search/?api=1&query=Shyamlal+Building+Begumpet+Hyderabad+500018');
            $table->string('whatsapp_number')->nullable()->default('+91 99081 17712');
            $table->text('map_embed_url')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_sections');
    }
};
