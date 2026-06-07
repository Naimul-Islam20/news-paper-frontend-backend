<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    /**
     * Fixed ad slots. Rows are recreated; run only on fresh/demo DB (wipes existing ad uploads refs).
     */
    public function run(): void
    {
        if (! \Schema::hasTable('advertisements')) {
            return;
        }

        $slots = [
            ['slug' => 'header', 'name' => 'হেডার (লোগো উপরে)'],
            ['slug' => 'below_menu', 'name' => 'মেনুর নিচে'],
            ['slug' => 'category_below_menu', 'name' => 'ক্যাটাগরি – মেনুর নিচে'],
            ['slug' => 'hero_right_1', 'name' => 'হোম – ডান কলাম উপরের অ্যাড'],
            ['slug' => 'hero_right_3', 'name' => 'হোম – ডান কলাম (মিনি সেকশনের নিচে)'],
            ['slug' => 'hero_right_2', 'name' => 'হোম – ডান কলাম নিচের অ্যাড'],
            ['slug' => 'hero_below', 'name' => 'হোম – হিরো নিচে (বর্ডার নিচে)'],
            ['slug' => 'home_video', 'name' => 'হোম – রাজনীতি সেকশনের ওপরে ভিডিও'],
            ['slug' => 'details_below_menu', 'name' => 'নিউজ ডিটেইল – মেনুর নিচে'],
            ['slug' => 'details_right_1', 'name' => 'ডিটেইল – ডান কলাম ১'],
            ['slug' => 'details_right_2', 'name' => 'ডিটেইল – ডান কলাম ২'],
            ['slug' => 'category_right_1', 'name' => 'ক্যাটাগরি – ডান কলাম ১'],
            ['slug' => 'category_right_2', 'name' => 'ক্যাটাগরি – ডান কলাম ২'],
        ];

        // Remove any old rows that are not part of the fixed slots (e.g. from previous seeder).
        Advertisement::query()->delete();

        foreach ($slots as $slot) {
            $now = now();
            Advertisement::create([
                'slug' => $slot['slug'],
                'name' => $slot['name'],
                'image' => null,
                'link' => null,
                'caption' => null,
                'video_youtube_id' => null,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addYear(),
            ]);
        }
    }
}
