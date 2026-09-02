<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('what_we_offers', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('what_we_offers', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
