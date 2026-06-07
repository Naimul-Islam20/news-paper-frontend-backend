<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_daily_visitors', function (Blueprint $table): void {
            $table->id();
            $table->date('date')->index();
            $table->string('path')->nullable()->index();
            $table->string('visitor_id', 191);
            $table->timestamps();

            $table->unique(['date', 'path', 'visitor_id'], 'visitor_daily_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_daily_visitors');
    }
};

