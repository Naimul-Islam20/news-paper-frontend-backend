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

        $rows = [
            [
                'slug' => 'category_right_1',
                'name' => 'ক্যাটাগরি – ডান কলাম ১',
            ],
            [
                'slug' => 'category_right_2',
                'name' => 'ক্যাটাগরি – ডান কলাম ২',
            ],
        ];

        foreach ($rows as $slot) {
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
        DB::table('advertisements')->whereIn('slug', ['category_right_1', 'category_right_2'])->delete();
    }
};
