<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LayoutController extends Controller
{
    public function frontend(): View
    {
        // Only parent (top-level) categories — subcategories excluded
        $categories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $headerCategoryIds = Setting::getJson('header_categories', []);
        $footerCategoryIds  = Setting::getJson('footer_categories', []);

        return view('admin.layout.frontend', compact(
            'categories',
            'headerCategoryIds',
            'footerCategoryIds'
        ));
    }

    public function home(): View
    {
        // Later we will map categories into each homepage section
        $categories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admin.layout.home', compact('categories'));
    }

    public function saveFrontend(Request $request): RedirectResponse
    {
        $request->validate([
            'header_categories'   => ['nullable', 'array'],
            'header_categories.*' => ['integer', 'exists:categories,id'],
            'footer_categories'   => ['nullable', 'array'],
            'footer_categories.*' => ['integer', 'exists:categories,id'],
        ]);

        Setting::setJson('header_categories', $request->input('header_categories', []));
        Setting::setJson('footer_categories', $request->input('footer_categories', []));

        return back()->with('success', 'Frontend layout settings saved successfully.');
    }
}
