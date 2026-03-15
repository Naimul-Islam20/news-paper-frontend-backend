<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reporters', function (Blueprint $table) {
            $table->string('desk')->nullable()->after('name');
            $table->foreignId('sub_editor_id')->nullable()->after('desk')->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('reporters', function (Blueprint $table) {
            $table->dropForeign(['sub_editor_id']);
            $table->dropColumn(['desk', 'sub_editor_id']);
        });
    }
};
