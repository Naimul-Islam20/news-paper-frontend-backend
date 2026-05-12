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

        $slug = 'category_below_menu';
        if (DB::table('advertisements')->where('slug', $slug)->exists()) {
            return;
        }

        $row = [
            'slug' => $slug,
            'name' => 'ক্যাটাগরি – মেনুর নিচে',
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

    public function down(): void
    {
        if (! Schema::hasTable('advertisements')) {
            return;
        }
        DB::table('advertisements')->where('slug', 'category_below_menu')->delete();
    }
};
