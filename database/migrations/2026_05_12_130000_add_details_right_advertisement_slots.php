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

        $renameMap = [
            'post_sidebar_1' => ['slug' => 'details_right_1', 'name' => 'ডিটেইল – ডান কলাম ১'],
            'post_sidebar_2' => ['slug' => 'details_right_2', 'name' => 'ডিটেইল – ডান কলাম ২'],
        ];

        foreach ($renameMap as $oldSlug => $new) {
            if (DB::table('advertisements')->where('slug', $new['slug'])->exists()) {
                continue;
            }
            if (DB::table('advertisements')->where('slug', $oldSlug)->exists()) {
                DB::table('advertisements')->where('slug', $oldSlug)->update([
                    'slug' => $new['slug'],
                    'name' => $new['name'],
                    'updated_at' => now(),
                ]);

                continue;
            }

            $row = [
                'slug' => $new['slug'],
                'name' => $new['name'],
                'image' => null,
                'link' => null,
                'caption' => null,
                'video_youtube_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (Schema::hasColumn('advertisements', 'image_mobile')) {
                $row['image_mobile'] = null;
            }

            DB::table('advertisements')->insert($row);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('advertisements')) {
            return;
        }

        $back = [
            'details_right_1' => ['slug' => 'post_sidebar_1', 'name' => 'পোস্ট ডিটেইল – ডান কলাম ১'],
            'details_right_2' => ['slug' => 'post_sidebar_2', 'name' => 'পোস্ট ডিটেইল – ডান কলাম ২'],
        ];

        foreach ($back as $from => $to) {
            if (DB::table('advertisements')->where('slug', $from)->exists()) {
                DB::table('advertisements')->where('slug', $from)->update([
                    'slug' => $to['slug'],
                    'name' => $to['name'],
                    'updated_at' => now(),
                ]);
            }
        }
    }
};
