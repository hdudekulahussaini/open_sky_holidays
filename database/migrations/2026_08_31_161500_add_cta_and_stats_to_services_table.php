<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (! Schema::hasColumn('services', 'cta_title')) {
                $table->string('cta_title')->nullable()->after('why_choose_items');
            }
            if (! Schema::hasColumn('services', 'cta_description')) {
                $table->text('cta_description')->nullable()->after('cta_title');
            }
            if (! Schema::hasColumn('services', 'cta_background_image')) {
                $table->string('cta_background_image')->nullable()->after('cta_description');
            }
            if (! Schema::hasColumn('services', 'stats')) {
                $table->json('stats')->nullable()->after('cta_background_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'cta_title',
                'cta_description',
                'cta_background_image',
                'stats',
            ]);
        });
    }
};
