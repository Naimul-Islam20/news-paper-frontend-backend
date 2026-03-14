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
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedTinyInteger('hero_layer')
                ->nullable()
                ->after('main_section_layer')
                ->comment('1-4 => hero layers for home page');

            $table->index(['hero_layer']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['hero_layer']);
            $table->dropColumn('hero_layer');
        });
    }
};

