<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('advertisements')) {
            return;
        }
        DB::table('advertisements')->whereIn('slug', ['post_top', 'sidebar_list'])->delete();
    }

    public function down(): void
    {
        if (! Schema::hasTable('advertisements')) {
            return;
        }

        $now = now();
        foreach (
            [
                ['slug' => 'post_top', 'name' => 'পোস্ট ডিটেইল – ডেস্কের উপরে'],
                ['slug' => 'sidebar_list', 'name' => 'ক্যাটাগরি/গ্যালারি/ভিডিও – ডান কলাম'],
            ] as $slot
        ) {
            if (DB::table('advertisements')->where('slug', $slot['slug'])->exists()) {
                continue;
            }
            $row = [
                'slug' => $slot['slug'],
                'name' => $slot['name'],
                'image' => null,
                'link' => null,
                'caption' => null,
                'video_youtube_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            if (Schema::hasColumn('advertisements', 'image_mobile')) {
                $row['image_mobile'] = null;
            }
            DB::table('advertisements')->insert($row);
        }
    }
};
