<?php

return [
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
            'size' => '1000×90 px',
            'note' => 'হেডার ব্যানার — উচ্চতা ফিক্সড, প্রস্থ সর্বোচ্চ ১০০০px',
        ],
        'below_menu' => [
            'ratio' => '≈10:1',
            'size' => '1000×100 px',
            'note' => 'মেনুর নিচে — পূর্ণ প্রস্থ ব্যানার',
        ],
        'category_below_menu' => [
            'ratio' => '≈10:1',
            'size' => '1000×100 px',
            'note' => 'ক্যাটাগরি পেজ — মেনুর নিচে ব্যানার',
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
            'ratio' => '≈10:1',
            'size' => '1000×100 px',
            'note' => 'হোম — হিরো সেকশনের নিচে ব্যানার',
        ],
        'home_video' => [
            'ratio' => '16:9',
            'size' => '1280×720 px',
            'note' => 'YouTube ভিডিও — aspect-video (১৬:৯)',
        ],
        'details_below_menu' => [
            'ratio' => '≈10:1',
            'size' => '1000×100 px',
            'note' => 'নিউজ ডিটেইল — মেনুর নিচে ব্যানার',
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
