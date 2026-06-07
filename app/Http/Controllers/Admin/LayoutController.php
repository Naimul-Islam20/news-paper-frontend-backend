<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomeLayoutSection;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LayoutController extends Controller
{
    public function frontend(): View
    {
        $categories = Category::whereNull('parent_id')
            ->orderByRaw("FIELD(type, 'post', 'video', 'gallery', 'page')")
            ->orderBy('name')
            ->get();

        $headerCategoryIds = Setting::getJson('header_categories', []);
        $footerCol2Ids     = Setting::getJson('footer_col2_categories', []);
        $footerCol3Ids     = Setting::getJson('footer_col3_categories', []);

        return view('admin.layout.frontend', compact(
            'categories',
            'headerCategoryIds',
            'footerCol2Ids',
            'footerCol3Ids'
        ));
    }

    public function home(): View
    {
        // Later we will map categories into each homepage section
        $categories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $sections = HomeLayoutSection::with('category')->get()->keyBy('key');

        return view('admin.layout.home', compact('categories', 'sections'));
    }

    /**
     * Section key => allowed category type. Video section = only video type, Gallery = only gallery, rest = only post.
     */
    private function sectionAllowedType(string $sectionId): string
    {
        return match ($sectionId) {
            'section-video'  => 'video',
            'section-gallery' => 'gallery',
            default           => 'post',
        };
    }

    public function saveHome(Request $request)
    {
        $data = $request->validate([
            'section_id'  => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
        ]);

        $categoryId = $data['category_id'] ?? null;
        $allowedType = $this->sectionAllowedType($data['section_id']);

        if ($categoryId) {
            $category = Category::find($categoryId);
            if (! $category || $category->type !== $allowedType) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "এই সেকশনে শুধুমাত্র {$allowedType} type এর category সিলেক্ট করতে পারবেন।",
                    ], 422);
                }
                return back()->with('error', "এই সেকশনে শুধুমাত্র {$allowedType} type এর category সিলেক্ট করতে পারবেন।");
            }

            // Ensure one category is used in only one section at a time
            HomeLayoutSection::where('category_id', $categoryId)
                ->where('key', '!=', $data['section_id'])
                ->update(['category_id' => null]);
        }

        $section = HomeLayoutSection::firstOrCreate(
            ['key' => $data['section_id']],
            ['label' => $data['section_id']]
        );
        $section->category_id = $categoryId;
        $section->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Home layout updated.');
    }

    public function saveFrontend(Request $request): RedirectResponse
    {
        $request->validate([
            'header_categories'      => ['nullable', 'array', 'max:16'],
            'header_categories.*'    => ['nullable', 'integer', 'exists:categories,id'],
            'footer_col2_categories'   => ['nullable', 'array', 'max:12'],
            'footer_col2_categories.*' => ['nullable', 'integer', 'exists:categories,id'],
            'footer_col3_categories'   => ['nullable', 'array', 'max:6'],
            'footer_col3_categories.*' => ['nullable', 'integer', 'exists:categories,id'],
        ]);

        Setting::setJson('header_categories', array_values(array_filter($request->input('header_categories', []))));
        Setting::setJson('footer_col2_categories', array_values(array_filter($request->input('footer_col2_categories', []))));
        Setting::setJson('footer_col3_categories', array_values(array_filter($request->input('footer_col3_categories', []))));

        return back()->with('success', 'Frontend layout settings saved successfully.');
    }
}
