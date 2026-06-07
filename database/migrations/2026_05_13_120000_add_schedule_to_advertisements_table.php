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
            if (! Schema::hasColumn('advertisements', 'starts_at')) {
                $table->timestamp('starts_at')->nullable()->after('video_youtube_id');
            }
            if (! Schema::hasColumn('advertisements', 'ends_at')) {
                $table->timestamp('ends_at')->nullable()->after('starts_at');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('advertisements')) {
            return;
        }
        Schema::table('advertisements', function (Blueprint $table) {
            if (Schema::hasColumn('advertisements', 'ends_at')) {
                $table->dropColumn('ends_at');
            }
            if (Schema::hasColumn('advertisements', 'starts_at')) {
                $table->dropColumn('starts_at');
            }
        });
    }
};
