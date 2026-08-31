<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            if (! Schema::hasColumn('tours', 'state')) {
                $table->string('state')->nullable()->after('country');
            }
            if (! Schema::hasColumn('tours', 'areas')) {
                $table->json('areas')->nullable()->after('thumbnail');
            }
            if (! Schema::hasColumn('tours', 'features')) {
                $table->json('features')->nullable()->after('areas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn([
                'state',
                'areas',
                'features',
            ]);
        });
    }
};
