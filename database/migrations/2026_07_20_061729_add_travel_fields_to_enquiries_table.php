<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->date('travel_date')
                ->nullable()
                ->after('phone');

            $table->string('destination')
                ->nullable()
                ->after('travel_date');

            $table->unsignedInteger('travelers')
                ->nullable()
                ->after('destination');

            $table->string('tour_type')
                ->nullable()
                ->after('travelers');
        });
    }

    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn([
                'travel_date',
                'destination',
                'travelers',
                'tour_type',
            ]);
        });
    }
};