<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Slot ID না থাকলে Auto OFF — Local ad যেন block না হয়
        DB::table('advertisements')
            ->where(function ($q) {
                $q->whereNull('google_ad_slot')->orWhere('google_ad_slot', '');
            })
            ->update(['google_ad_auto' => false]);
    }

    public function down(): void
    {
        // no-op
    }
};
