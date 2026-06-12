<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->boolean('google_ad_auto')->default(true)->after('google_ad_slot');
        });
    }

    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn('google_ad_auto');
        });
    }
};
