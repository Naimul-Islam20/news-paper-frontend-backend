<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('site_meta') && Schema::hasColumn('site_meta', 'home_video_youtube_id')) {
            Schema::table('site_meta', function (Blueprint $table) {
                $table->dropColumn('home_video_youtube_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->string('home_video_youtube_id', 20)->nullable()->after('youtube_link');
        });
    }
};
