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
        Schema::table('about_sections', function (Blueprint $table) {
            if (! Schema::hasColumn('about_sections', 'mission_icon')) {
                $table->string('mission_icon')->nullable()->default('fa-solid fa-bullseye')->after('mission_title');
            }

            if (! Schema::hasColumn('about_sections', 'focus_icon')) {
                $table->string('focus_icon')->nullable()->default('fa-solid fa-crosshairs')->after('focus_title');
            }

            if (! Schema::hasColumn('about_sections', 'destinations_subtitle')) {
                $table->string('destinations_subtitle')->nullable()->default('Click any country to view tours')->after('customer_count');
            }

            if (Schema::hasColumn('about_sections', 'destinations_title')) {
                $table->dropColumn('destinations_title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            if (Schema::hasColumn('about_sections', 'destinations_subtitle')) {
                $table->dropColumn('destinations_subtitle');
            }
        });
    }
};
