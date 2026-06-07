<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Reporter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Wipe existing demo data so we can reseed cleanly
        Schema::disableForeignKeyConstraints();
        DB::table('category_post')->truncate();
        Post::truncate();
        Schema::enableForeignKeyConstraints();

        $reporterIds = Reporter::pluck('id')->all();
        $categories  = Category::where('status', 'active')->get();

        if ($categories->isEmpty()) {
            return;
        }

        $layeredSlots = [
            '1' => 'প্রধান শিরোনাম সংবাদ',
            '2' => 'দ্বিতীয় স্তরের গুরুত্বপূর্ণ সংবাদ',
            '3' => 'তৃতীয় স্তরের হাইলাইট সংবাদ',
            '4' => 'চতুর্থ স্তরের নির্বাচিত সংবাদ',
        ];

        foreach ($layeredSlots as $layer => $prefix) {
            for ($i = 1; $i <= 3; $i++) {
                $title = "{$prefix} - {$i}";

                $post = Post::updateOrCreate(
                    ['slug' => Str::slug($title)],
                    [
                        'title' => $title,
                        'sub_title' => null,
                        'description' => $this->fakeParagraphs(),
                        'image' => "posts/lead-{$layer}-{$i}.jpg",
                        'image_caption' => 'ডেমো ফিচার ছবি',
                        'reporter_id' => ! empty($reporterIds) ? Arr::random($reporterIds) : null,
                        'seo_keywords' => $title,
                        'status' => 'published',
                        'hero_layer' => (int) $layer,
                    ],
                );

                // Attach exactly ONE category to this post
                $singleCategoryId = $categories->random()->id;
                $post->categories()->sync([$singleCategoryId]);
            }
        }

        $baseTitles = [
            'বাজারে নতুন মূল্যস্ফীতি',
            'বিশ্বকাপের নতুন চমক',
            'ঢাকার যানজটের নতুন রূপ',
            'প্রযুক্তি জগতে নতুন উদ্ভাবন',
            'স্বাস্থ্য সচেতনতার নতুন উদ্যোগ',
            'চলচ্চিত্রে নতুন ধারার সূচনা',
            'স্থানীয় সরকারের নতুন পরিকল্পনা',
            'শিক্ষা ব্যবস্থার নতুন সংস্কার',
        ];

        foreach ($categories as $category) {
            for ($i = 1; $i <= 15; $i++) {
                $baseTitle = $baseTitles[array_rand($baseTitles)];
                $title = "{$category->name}: {$baseTitle} ({$i})";
                $slug = Str::slug($category->slug . '-' . $baseTitle . '-' . $i);

                $post = Post::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'title' => $title,
                        'sub_title' => null,
                        'description' => $this->fakeParagraphs(),
                        'image' => "posts/{$category->slug}-{$i}.jpg",
                        'image_caption' => $category->name . ' সংবাদ',
                        'reporter_id' => ! empty($reporterIds) ? Arr::random($reporterIds) : null,
                        'seo_keywords' => $title,
                        'status' => 'published',
                        'hero_layer' => null,
                    ],
                );

                // Ensure the post belongs to ONLY this category
                $post->categories()->sync([$category->id]);
            }
        }
    }

    private function fakeParagraphs(): string
    {
        $paragraph = 'এটি একটি ডেমো অনুচ্ছেদ যা কেবলমাত্র ডেভেলপমেন্ট ও টেস্টিং-এর উদ্দেশ্যে ব্যবহার করা হচ্ছে। বাস্তব সংবাদের পরিবর্তে এখানে সাধারণ প্লেসহোল্ডার টেক্সট দেখানো হচ্ছে।';

        return implode("\n\n", [$paragraph, $paragraph, $paragraph]);
    }
}

