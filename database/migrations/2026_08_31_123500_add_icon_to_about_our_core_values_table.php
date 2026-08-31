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
        Schema::table('about_our_core_values', function (Blueprint $table) {
            if (! Schema::hasColumn('about_our_core_values', 'icon')) {
                $table->string('icon')->nullable()->default('fa-solid fa-heart')->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_our_core_values', function (Blueprint $table) {
            if (Schema::hasColumn('about_our_core_values', 'icon')) {
                $table->dropColumn('icon');
            }
        });
    }
};
