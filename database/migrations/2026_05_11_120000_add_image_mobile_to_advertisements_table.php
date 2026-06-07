<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('advertisements')) {
            return;
        }
        Schema::table('advertisements', function (Blueprint $table) {
            if (! Schema::hasColumn('advertisements', 'image_mobile')) {
                $table->string('image_mobile')->nullable()->after('image');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('advertisements')) {
            return;
        }
        Schema::table('advertisements', function (Blueprint $table) {
            if (Schema::hasColumn('advertisements', 'image_mobile')) {
                $table->dropColumn('image_mobile');
            }
        });
    }
};
