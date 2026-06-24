<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->string('editor_label')->nullable()->after('editor_name');
            $table->string('publisher_label')->nullable()->after('publisher_name');
        });
    }

    public function down(): void
    {
        Schema::table('site_meta', function (Blueprint $table) {
            $table->dropColumn(['editor_label', 'publisher_label']);
        });
    }
};
