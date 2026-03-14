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
        Schema::create('home_layout_sections', function (Blueprint $table) {
            $table->id();

            // Unique key for each slot in the home layout
            // Example values:
            // hero_layer_1, hero_layer_2, hero_layer_3, hero_layer_4,
            // mini_section,
            // politics, national, capital, sports, countrywide, world, entertainment,
            // lifestyle, tech, different_eye, generation, campus, job,
            // video, gallery
            $table->string('key')->unique();

            // Default human readable label (e.g. "Layer 1", "রাজনীতি")
            $table->string('label');

            // Optional logical group for easier querying (e.g. "hero", "top_row", "feature_row", "media_row")
            $table->string('section_group')->nullable();

            // Selected category for this section (can be null if nothing chosen yet)
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            // Position inside a group (for ordering if needed)
            $table->unsignedInteger('position')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_layout_sections');
    }
};

