<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('ad_source', 16)->default('local')->after('slug');
            $table->string('google_ad_slot', 32)->nullable()->after('ad_source');
        });
    }

    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn(['ad_source', 'google_ad_slot']);
        });
    }
};
