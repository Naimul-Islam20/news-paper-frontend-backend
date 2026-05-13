<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->string('primary_color', 7)->nullable()->after('site_description');
        });
    }

    public function down(): void
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->dropColumn('primary_color');
        });
    }
};
