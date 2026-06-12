<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('reporters')->whereNull('sub_editor_id')->delete();

        $validUserIds = DB::table('users')->pluck('id');
        DB::table('reporters')
            ->whereNotNull('sub_editor_id')
            ->whereNotIn('sub_editor_id', $validUserIds)
            ->delete();

        Schema::table('reporters', function (Blueprint $table) {
            $table->dropForeign(['sub_editor_id']);
        });

        Schema::table('reporters', function (Blueprint $table) {
            $table->foreign('sub_editor_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('reporters', function (Blueprint $table) {
            $table->dropForeign(['sub_editor_id']);
        });

        Schema::table('reporters', function (Blueprint $table) {
            $table->foreign('sub_editor_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }
};
