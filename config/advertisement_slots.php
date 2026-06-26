<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google AdSense — প্রতি পেজে সর্বোচ্চ কতটি unit (একই পেজে বেশি হলে সাইট আটকে যেতে পারে)
    |--------------------------------------------------------------------------
    */
    'google_ads_max_per_page' => (int) env('GOOGLE_ADS_MAX_PER_PAGE', 2),

    /*
    |--------------------------------------------------------------------------
    | Advertisement slot media specs (frontend display ratios)
    |--------------------------------------------------------------------------
    |
    | ratio — CSS aspect ratio used on the frontend
    | size  — recommended upload dimensions (width × height)
    |
    */
    'media_specs' => [
        'header' => [
            'ratio' => '≈11:1',
            'size' => '1300×90 px',
            'note' => 'হেডার ব্যানার — site width, উচ্চতা ৯০px',
        ],
        'below_menu' => [
            'ratio' => '≈13:1',
            'size' => '1300×100 px',
            'note' => 'মেনুর নিচে — site width, উচ্চতা ১০০px',
        ],
        'category_below_menu' => [
            'ratio' => '≈13:1',
            'size' => '1300×100 px',
            'note' => 'ক্যাটাগরি পেজ — site width, উচ্চতা ১০০px',
        ],
        'hero_right_1' => [
            'ratio' => '4:3',
            'size' => '800×600 px',
            'note' => 'হোম — ডান কলাম (উপর)',
        ],
        'hero_right_3' => [
            'ratio' => '4:3',
            'size' => '800×600 px',
            'note' => 'হোম — ডান কলাম (মিনি সেকশনের নিচে)',
        ],
        'hero_right_2' => [
            'ratio' => '4:3',
            'size' => '800×600 px',
            'note' => 'হোম — ডান কলাম (নিচে)',
        ],
        'hero_below' => [
            'ratio' => '≈13:1',
            'size' => '1300×100 px',
            'note' => 'হোম — হিরো সেকশনের নিচে — site width, উচ্চতা ১০০px',
        ],
        'home_video' => [
            'ratio' => '16:9',
            'size' => '1280×720 px',
            'note' => 'YouTube ভিডিও — aspect-video (১৬:৯)',
        ],
        'details_below_menu' => [
            'ratio' => '≈13:1',
            'size' => '1300×100 px',
            'note' => 'নিউজ ডিটেইল — মেনুর নিচে — site width, উচ্চতা ১০০px',
        ],
        'details_right_1' => [
            'ratio' => '4:3',
            'size' => '800×600 px',
            'note' => 'নিউজ ডিটেইল — ডান সাইডবার (১)',
        ],
        'details_right_2' => [
            'ratio' => '4:3',
            'size' => '800×600 px',
            'note' => 'নিউজ ডিটেইল — ডান সাইডবার (২)',
        ],
        'category_right_1' => [
            'ratio' => '4:3',
            'size' => '800×600 px',
            'note' => 'ক্যাটাগরি — ডান সাইডবার (১)',
        ],
        'category_right_2' => [
            'ratio' => '4:3',
            'size' => '800×600 px',
            'note' => 'ক্যাটাগরি — ডান সাইডবার (২)',
        ],
    ],
];
