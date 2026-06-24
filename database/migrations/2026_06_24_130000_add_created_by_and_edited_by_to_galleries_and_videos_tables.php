<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->after('reporter_id')
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('edited_by')
                ->nullable()
                ->after('created_by')
                ->constrained('users')
                ->nullOnDelete();
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->after('reporter_id')
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('edited_by')
                ->nullable()
                ->after('created_by')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('edited_by');
            $table->dropConstrainedForeignId('created_by');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('edited_by');
            $table->dropConstrainedForeignId('created_by');
        });
    }
};
