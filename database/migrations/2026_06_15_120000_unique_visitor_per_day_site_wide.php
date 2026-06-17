<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitor_daily_visitors', function (Blueprint $table): void {
            $table->dropUnique('visitor_daily_unique');
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('
                DELETE v1 FROM visitor_daily_visitors v1
                INNER JOIN visitor_daily_visitors v2
                    ON v1.date = v2.date
                    AND v1.visitor_id = v2.visitor_id
                    AND v1.id > v2.id
            ');
        }

        Schema::table('visitor_daily_visitors', function (Blueprint $table): void {
            $table->unique(['date', 'visitor_id'], 'visitor_daily_site_unique');
        });
    }

    public function down(): void
    {
        Schema::table('visitor_daily_visitors', function (Blueprint $table): void {
            $table->dropUnique('visitor_daily_site_unique');
        });

        Schema::table('visitor_daily_visitors', function (Blueprint $table): void {
            $table->unique(['date', 'path', 'visitor_id'], 'visitor_daily_unique');
        });
    }
};
