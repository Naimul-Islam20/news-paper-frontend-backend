<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $structures = [
            'national' => [
                'label' => 'জাতীয়',
                'children' => [
                    'politics' => 'রাজনীতি',
                    'administration' => 'প্রশাসন',
                    'crime' => 'অপরাধ',
                ],
            ],
            'international' => [
                'label' => 'আন্তর্জাতিক',
                'children' => [
                    'asia' => 'এশিয়া',
                    'europe' => 'ইউরোপ',
                    'america' => 'আমেরিকা',
                ],
            ],
            'business' => [
                'label' => 'অর্থনীতি',
                'children' => [
                    'stock-market' => 'শেয়ারবাজার',
                    'banking' => 'ব্যাংক',
                ],
            ],
            'sports' => [
                'label' => 'খেলা',
                'children' => [
                    'cricket' => 'ক্রিকেট',
                    'football' => 'ফুটবল',
                    'others-sports' => 'অন্যান্য',
                ],
            ],
            'entertainment' => [
                'label' => 'বিনোদন',
                'children' => [
                    'movie' => 'চলচ্চিত্র',
                    'television' => 'টেলিভিশন',
                    'music' => 'সঙ্গীত',
                ],
            ],
            'lifestyle' => [
                'label' => 'লাইফস্টাইল',
                'children' => [
                    'health' => 'স্বাস্থ্য',
                    'food' => 'খাদ্য',
                    'travel' => 'ভ্রমণ',
                ],
            ],
            'opinion' => [
                'label' => 'মতামত',
                'children' => [],
            ],
        ];

        foreach ($structures as $key => $config) {
            $parent = Category::updateOrCreate(
                ['slug' => $key],
                [
                    'name' => $config['label'],
                    'slug' => $key,
                    'type' => 'post',
                    'description' => $config['label'] . ' সংক্রান্ত সব খবর',
                    'parent_id' => null,
                    'status' => 'active',
                ],
            );

            foreach ($config['children'] as $childKey => $childLabel) {
                Category::updateOrCreate(
                    ['slug' => $childKey],
                    [
                        'name' => $childLabel,
                        'slug' => $childKey,
                        'type' => 'post',
                        'description' => $childLabel . ' সংক্রান্ত খবর',
                        'parent_id' => $parent->id,
                        'status' => 'active',
                    ],
                );
            }
        }
    }
}

