<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('advertisements')
            ->where('slug', '!=', 'home_video')
            ->whereNotNull('google_ad_slot')
            ->where('google_ad_slot', '!=', '')
            ->update(['google_ad_auto' => true]);
    }

    public function down(): void
    {
        // no-op
    }
};
