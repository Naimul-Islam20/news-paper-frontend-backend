<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show a single CMS page whose category type is "page".
     */
    public function show(string $slug): View
    {
        $page = Page::with('category')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('frontend.page', compact('page'));
    }
}

