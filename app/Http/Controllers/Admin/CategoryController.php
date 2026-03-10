<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        // Mock data for the view
        $categories = [
            [
                'id' => 1,
                'name' => 'National',
                'type' => 'Main',
                'subcategory' => 'Politics, Economy',
                'status' => 'Active',
                'description' => 'Breaking news from across the nation.',
            ],
            [
                'id' => 2,
                'name' => 'Sports',
                'type' => 'Main',
                'subcategory' => 'Football, Cricket',
                'status' => 'Active',
                'description' => 'Latest scores and sports highlights.',
            ],
            [
                'id' => 3,
                'name' => 'International',
                'type' => 'Main',
                'subcategory' => 'World News, Global Events',
                'status' => 'Active',
                'description' => 'Stories from around the globe.',
            ],
            [
                'id' => 4,
                'name' => 'Technology',
                'type' => 'Special',
                'subcategory' => 'AI, Gadgets',
                'status' => 'Inactive',
                'description' => 'The latest in the tech world.',
            ],
        ];

        return view('admin.category.index', compact('categories'));
    }

    public function subCategoryIndex()
    {
        // Mock data for sub-categories
        $subCategories = [
            [
                'id' => 1,
                'name' => 'Politics',
                'parent' => 'National',
                'serial' => 1,
                'status' => 'Active',
            ],
            [
                'id' => 2,
                'name' => 'Economy',
                'parent' => 'National',
                'serial' => 2,
                'status' => 'Active',
            ],
            [
                'id' => 3,
                'name' => 'Football',
                'parent' => 'Sports',
                'serial' => 1,
                'status' => 'Active',
            ],
            [
                'id' => 4,
                'name' => 'Cricket',
                'parent' => 'Sports',
                'serial' => 2,
                'status' => 'Active',
            ],
            [
                'id' => 5,
                'name' => 'World News',
                'parent' => 'International',
                'serial' => 1,
                'status' => 'Active',
            ],
        ];

        // We also need categories for the "Add" modal
        $categories = [
            ['id' => 1, 'name' => 'National'],
            ['id' => 2, 'name' => 'Sports'],
            ['id' => 3, 'name' => 'International'],
            ['id' => 4, 'name' => 'Technology'],
        ];

        return view('admin.category.sub_index', compact('subCategories', 'categories'));
    }
}
