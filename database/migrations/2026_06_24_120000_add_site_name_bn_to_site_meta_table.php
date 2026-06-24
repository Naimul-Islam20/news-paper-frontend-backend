<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->string('site_name_bn')->nullable()->after('site_name');
        });
    }

    public function down(): void
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->dropColumn('site_name_bn');
        });
    }
};
