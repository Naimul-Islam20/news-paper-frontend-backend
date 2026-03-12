<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        if (! \Schema::hasTable('advertisements')) {
            return;
        }

        // The current advertisements table only has id and timestamps.
        // We simply create a few placeholder rows so that any listing
        // views have data to work with, without assuming extra columns.
        $slots = [
            'Top Header Banner',
            'Sidebar Top',
            'Sidebar Middle',
            'Inline Section',
            'Footer Banner',
        ];

        foreach ($slots as $index => $title) {
            Advertisement::updateOrCreate(['id' => $index + 1], []);
        }
    }
}

