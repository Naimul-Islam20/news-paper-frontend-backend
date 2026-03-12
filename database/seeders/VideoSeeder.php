<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $videoCategory = Category::firstOrCreate(
            ['slug' => 'video'],
            [
                'name' => 'ভিডিও',
                'type' => 'post',
                'description' => 'ভিডিও সংবাদ',
                'parent_id' => null,
                'status' => 'active',
            ],
        );

        $sampleLinks = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://www.youtube.com/watch?v=oHg5SJYRHA0',
            'https://www.youtube.com/watch?v=3GwjfUFyY6M',
            'https://www.youtube.com/watch?v=2Z4m4lnjxkY',
        ];

        $titles = [
            'আজকের প্রধান ভিডিও সংবাদ',
            'খেলার মাঠ থেকে সরাসরি',
            'অর্থনীতি বিশ্লেষণ',
            'বিনোদন জগতের নতুন খবর',
            'লাইফস্টাইল ফিচার ভিডিও',
            'বিশেষ সাক্ষাৎকার',
            'রাজনীতি টকশো',
            'আন্তর্জাতিক আপডেট',
        ];

        foreach ($titles as $index => $title) {
            $isMain = $index < 3 ? 'yes' : 'no';
            $link = $sampleLinks[$index % count($sampleLinks)];

            Video::updateOrCreate(
                ['slug' => Str::slug($title) . '-' . $index],
                [
                    'category_id' => $videoCategory->id,
                    'title' => $title,
                    'slug' => Str::slug($title) . '-' . $index,
                    'youtube_link' => $link,
                    'image' => null,
                    'description' => $title . ' ভিডিও রিপোর্ট।',
                    'status' => 'active',
                    'is_main_video' => $isMain,
                ],
            );
        }
    }
}

