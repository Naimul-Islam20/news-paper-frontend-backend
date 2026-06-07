<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('advertisement_queue_items')) {
            return;
        }

        Schema::table('advertisement_queue_items', function (Blueprint $table) {
            if (! Schema::hasColumn('advertisement_queue_items', 'duration_days')) {
                $table->unsignedSmallInteger('duration_days')->default(0)->after('sort_order');
            }
            if (! Schema::hasColumn('advertisement_queue_items', 'duration_hours')) {
                $table->unsignedSmallInteger('duration_hours')->default(0)->after('duration_days');
            }
            if (! Schema::hasColumn('advertisement_queue_items', 'display_started_at')) {
                $table->timestamp('display_started_at')->nullable()->after('duration_hours');
            }
            if (! Schema::hasColumn('advertisement_queue_items', 'expired_at')) {
                $table->timestamp('expired_at')->nullable()->after('display_started_at');
            }
        });

        if (Schema::hasColumn('advertisement_queue_items', 'duration_days')) {
            $q = DB::table('advertisement_queue_items')
                ->where('duration_days', 0)
                ->where('duration_hours', 0)
                ->whereNull('expired_at');
            if (Schema::hasColumn('advertisement_queue_items', 'starts_at')) {
                $q->whereNull('starts_at');
            }
            if (Schema::hasColumn('advertisement_queue_items', 'ends_at')) {
                $q->whereNull('ends_at');
            }
            $q->update(['duration_days' => 7, 'duration_hours' => 0]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('advertisement_queue_items')) {
            return;
        }

        Schema::table('advertisement_queue_items', function (Blueprint $table) {
            foreach (['expired_at', 'display_started_at', 'duration_hours', 'duration_days'] as $col) {
                if (Schema::hasColumn('advertisement_queue_items', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
