<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $photoCategory = Category::firstOrCreate(
            ['slug' => 'photo-feature'],
            [
                'name' => 'ফটো ফিচার',
                'type' => 'post',
                'description' => 'বিশেষ ফটো ফিচার',
                'parent_id' => null,
                'status' => 'active',
            ],
        );

        $galleryConfigs = [
            ['title' => 'আজকের ছবি', 'category' => $photoCategory],
            ['title' => 'রাজনীতির দিনকাল', 'category' => $photoCategory],
            ['title' => 'খেলার মাঠের উত্তেজনা', 'category' => Category::where('slug', 'sports')->first() ?? $photoCategory],
            ['title' => 'ঢাকার জীবনযাপন', 'category' => Category::where('slug', 'lifestyle')->first() ?? $photoCategory],
        ];

        foreach ($galleryConfigs as $config) {
            $gallery = Gallery::updateOrCreate(
                ['slug' => Str::slug($config['title'])],
                [
                    'category_id' => $config['category']->id,
                    'title' => $config['title'],
                    'slug' => Str::slug($config['title']),
                    'status' => 'active',
                    'description' => $config['title'] . ' সংক্রান্ত ছবির সমাহার',
                ],
            );

            if ($gallery->images()->count() === 0) {
                for ($i = 1; $i <= 6; $i++) {
                    GalleryImage::create([
                        'gallery_id' => $gallery->id,
                        'image' => "galleries/demo-{$gallery->id}-{$i}.jpg",
                        'description' => $config['title'] . " - ছবি {$i}",
                    ]);
                }
            }
        }
    }
}

