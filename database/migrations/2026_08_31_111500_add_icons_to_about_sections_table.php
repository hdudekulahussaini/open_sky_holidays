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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            if (Schema::hasColumn('about_sections', 'mission_icon')) {
                $table->dropColumn('mission_icon');
            }
            if (Schema::hasColumn('about_sections', 'focus_icon')) {
                $table->dropColumn('focus_icon');
            }
        });
    }
};
