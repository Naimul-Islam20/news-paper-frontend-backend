<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get(['id', 'name']);

        $subCategories = Category::whereNotNull('parent_id')
            ->with('parent:id,name')
            ->orderBy('parent_id')
            ->orderBy('name')
            ->get()
            ->map(function (Category $category, int $index) {
                return [
                    'id'          => $category->id,
                    'name'        => $category->name,
                    'parent_id'   => $category->parent_id,
                    'parent'      => optional($category->parent)->name ?? '-',
                    'type'        => $category->type ?? 'general',
                    'description' => $category->description,
                    'serial'      => $index + 1,
                    'status'      => $category->status === 'active' ? 'Active' : 'Inactive',
                    'rawStatus'   => $category->status,
                ];
            })
            ->toArray();

        return view('admin.category.sub_index', compact('categories', 'subCategories'));
    }
}


