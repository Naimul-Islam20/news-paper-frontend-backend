<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('advertisement_queue_items')) {
            return;
        }

        Schema::table('advertisement_queue_items', function (Blueprint $table) {
            if (! Schema::hasColumn('advertisement_queue_items', 'title')) {
                $table->string('title')->nullable()->after('sort_order');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('advertisement_queue_items')) {
            return;
        }

        Schema::table('advertisement_queue_items', function (Blueprint $table) {
            if (Schema::hasColumn('advertisement_queue_items', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};
