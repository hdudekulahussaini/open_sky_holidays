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
        Schema::table('counters', function (Blueprint $table) {
            if (! Schema::hasColumn('counters', 'icon')) {
                $table->string('icon')->nullable()->default('fa-solid fa-users')->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counters', function (Blueprint $table) {
            if (Schema::hasColumn('counters', 'icon')) {
                $table->dropColumn('icon');
            }
        });
    }
};
