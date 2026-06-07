<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $infoCategory = Category::firstOrCreate(
            ['slug' => 'info-pages'],
            [
                'name' => 'তথ্য',
                'type' => 'general',
                'description' => 'ওয়েবসাইট সম্পর্কিত তথ্য পেজসমূহ',
                'parent_id' => null,
                'status' => 'active',
            ],
        );

        $pages = [
            ['title' => 'About Us', 'content' => 'This is a demo Bangla newspaper site created for development and testing purposes.'],
            ['title' => 'Contact Us', 'content' => 'Reach us via email, phone, or the contact form on the website.'],
            ['title' => 'Privacy Policy', 'content' => 'Sample privacy policy text describing how user data is handled.'],
            ['title' => 'Terms & Conditions', 'content' => 'Sample terms & conditions text for the demo site.'],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => Str::slug($page['title'])],
                [
                    'category_id' => $infoCategory->id,
                    'title' => $page['title'],
                    'slug' => Str::slug($page['title']),
                    'content' => $page['content'],
                    'image' => null,
                    'status' => 'active',
                ],
            );
        }
    }
}

