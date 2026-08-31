<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_why_choose_us', function (Blueprint $table) {
            if (!Schema::hasColumn('about_why_choose_us', 'subtitle')) {
                $table->string('subtitle')->nullable()->after('title');
            }
            if (!Schema::hasColumn('about_why_choose_us', 'features_icon')) {
                $table->json('features_icon')->nullable()->after('image');
            }
            if (!Schema::hasColumn('about_why_choose_us', 'badge_title')) {
                $table->string('badge_title')->nullable()->default('Trusted by 15,000+')->after('features_description');
            }
            if (!Schema::hasColumn('about_why_choose_us', 'badge_subtitle')) {
                $table->string('badge_subtitle')->nullable()->default('Happy travelers worldwide')->after('badge_title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('about_why_choose_us', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('about_why_choose_us', 'subtitle')) {
                $columns[] = 'subtitle';
            }
            if (Schema::hasColumn('about_why_choose_us', 'features_icon')) {
                $columns[] = 'features_icon';
            }
            if (Schema::hasColumn('about_why_choose_us', 'badge_title')) {
                $columns[] = 'badge_title';
            }
            if (Schema::hasColumn('about_why_choose_us', 'badge_subtitle')) {
                $columns[] = 'badge_subtitle';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
