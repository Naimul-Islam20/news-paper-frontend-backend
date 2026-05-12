<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('advertisements')) {
            return;
        }
        Schema::table('advertisements', function (Blueprint $table) {
            if (! Schema::hasColumn('advertisements', 'views_count')) {
                $table->unsignedBigInteger('views_count')->default(0)->after('ends_at');
            }
            if (! Schema::hasColumn('advertisements', 'clicks_count')) {
                $table->unsignedBigInteger('clicks_count')->default(0)->after('views_count');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('advertisements')) {
            return;
        }
        Schema::table('advertisements', function (Blueprint $table) {
            if (Schema::hasColumn('advertisements', 'clicks_count')) {
                $table->dropColumn('clicks_count');
            }
            if (Schema::hasColumn('advertisements', 'views_count')) {
                $table->dropColumn('views_count');
            }
        });
    }
};
