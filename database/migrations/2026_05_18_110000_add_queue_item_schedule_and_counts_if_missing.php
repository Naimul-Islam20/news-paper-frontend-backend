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
            if (! Schema::hasColumn('advertisement_queue_items', 'starts_at')) {
                $table->timestamp('starts_at')->nullable();
            }
            if (! Schema::hasColumn('advertisement_queue_items', 'ends_at')) {
                $table->timestamp('ends_at')->nullable();
            }
            if (! Schema::hasColumn('advertisement_queue_items', 'views_count')) {
                $table->unsignedBigInteger('views_count')->default(0);
            }
            if (! Schema::hasColumn('advertisement_queue_items', 'clicks_count')) {
                $table->unsignedBigInteger('clicks_count')->default(0);
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('advertisement_queue_items')) {
            return;
        }

        Schema::table('advertisement_queue_items', function (Blueprint $table) {
            foreach (['clicks_count', 'views_count', 'ends_at', 'starts_at'] as $col) {
                if (Schema::hasColumn('advertisement_queue_items', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
