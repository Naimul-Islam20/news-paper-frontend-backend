<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->foreignId('reporter_id')->nullable()->after('category_id')->constrained('reporters')->onDelete('set null');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->foreignId('reporter_id')->nullable()->after('category_id')->constrained('reporters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['reporter_id']);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['reporter_id']);
        });
    }
};
