<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->boolean('local_ad_paused')->default(false)->after('google_ad_auto');
            $table->unsignedInteger('local_ad_paused_remaining_seconds')->nullable()->after('local_ad_paused');
        });
    }

    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn(['local_ad_paused', 'local_ad_paused_remaining_seconds']);
        });
    }
};
