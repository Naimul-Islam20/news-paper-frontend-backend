<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    /**
     * Fixed ad slots: 9 rows. No new slots are added; only these are updated from admin.
     */
    public function run(): void
    {
        if (! \Schema::hasTable('advertisements')) {
            return;
        }

        $slots = [
            ['slug' => 'header', 'name' => 'হেডার (লোগো উপরে)'],
            ['slug' => 'below_menu', 'name' => 'মেনুর নিচে'],
            ['slug' => 'hero_right_1', 'name' => 'হোম – ডান কলাম উপরের অ্যাড'],
            ['slug' => 'hero_right_2', 'name' => 'হোম – ডান কলাম নিচের অ্যাড'],
            ['slug' => 'hero_below', 'name' => 'হোম – হিরো নিচে (বর্ডার নিচে)'],
            ['slug' => 'home_video', 'name' => 'হোম – রাজনীতি সেকশনের ওপরে ভিডিও'],
            ['slug' => 'post_top', 'name' => 'পোস্ট ডিটেইল – ডেস্কের উপরে'],
            ['slug' => 'post_sidebar_1', 'name' => 'পোস্ট ডিটেইল – ডান কলাম ১'],
            ['slug' => 'post_sidebar_2', 'name' => 'পোস্ট ডিটেইল – ডান কলাম ২'],
            ['slug' => 'sidebar_list', 'name' => 'ক্যাটাগরি/গ্যালারি/ভিডিও – ডান কলাম'],
        ];

        // Remove any old rows that are not part of the fixed slots (e.g. from previous seeder).
        Advertisement::query()->delete();

        foreach ($slots as $slot) {
            Advertisement::create([
                'slug' => $slot['slug'],
                'name' => $slot['name'],
                'image' => null,
                'link' => null,
                'caption' => null,
                'video_youtube_id' => null,
            ]);
        }
    }
}
