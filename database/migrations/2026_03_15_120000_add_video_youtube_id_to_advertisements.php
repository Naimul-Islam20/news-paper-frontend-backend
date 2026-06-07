<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('video_youtube_id', 20)->nullable()->after('caption');
        });

        // Add the new home_video slot if it doesn't exist
        $slug = 'home_video';
        if (\Schema::hasTable('advertisements') && !\DB::table('advertisements')->where('slug', $slug)->exists()) {
            \DB::table('advertisements')->insert([
                'slug' => $slug,
                'name' => 'হোম – রাজনীতি সেকশনের ওপরে ভিডিও',
                'image' => null,
                'link' => null,
                'caption' => null,
                'video_youtube_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        \DB::table('advertisements')->where('slug', 'home_video')->delete();
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn('video_youtube_id');
        });
    }
};
