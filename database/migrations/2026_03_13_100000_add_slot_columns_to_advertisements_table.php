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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('id');
            $table->string('name')->nullable()->after('slug');
            $table->string('image')->nullable()->after('name');
            $table->string('link')->nullable()->after('image');
            $table->string('caption')->nullable()->after('link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn(['slug', 'name', 'image', 'link', 'caption']);
        });
    }
};
