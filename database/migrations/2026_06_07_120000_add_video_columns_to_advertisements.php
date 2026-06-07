<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            if (! Schema::hasColumn('advertisements', 'video')) {
                $table->string('video')->nullable()->after('image_mobile');
            }
            if (! Schema::hasColumn('advertisements', 'video_mobile')) {
                $table->string('video_mobile')->nullable()->after('video');
            }
        });

        Schema::table('advertisement_queue_items', function (Blueprint $table) {
            if (! Schema::hasColumn('advertisement_queue_items', 'video')) {
                $table->string('video')->nullable()->after('image_mobile');
            }
            if (! Schema::hasColumn('advertisement_queue_items', 'video_mobile')) {
                $table->string('video_mobile')->nullable()->after('video');
            }
        });
    }

    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn(['video', 'video_mobile']);
        });

        Schema::table('advertisement_queue_items', function (Blueprint $table) {
            $table->dropColumn(['video', 'video_mobile']);
        });
    }
};
