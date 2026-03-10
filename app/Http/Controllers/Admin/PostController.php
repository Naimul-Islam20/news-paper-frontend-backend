<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


class PostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index');
    }

    public function create()
    {
        // Hierarchical Categories for the selection box
        $categories = [
            [
                'id' => 1, 
                'name' => 'National',
                'sub_categories' => [
                    ['id' => 101, 'name' => 'Politics'],
                    ['id' => 102, 'name' => 'Economy'],
                    ['id' => 103, 'name' => 'Education'],
                ]
            ],
            [
                'id' => 2, 
                'name' => 'Sports',
                'sub_categories' => [
                    ['id' => 201, 'name' => 'Cricket'],
                    ['id' => 202, 'name' => 'Football'],
                ]
            ],
            [
                'id' => 3, 
                'name' => 'International',
                'sub_categories' => [
                    ['id' => 301, 'name' => 'Middle East'],
                    ['id' => 302, 'name' => 'Europe'],
                ]
            ],
            [
                'id' => 4, 
                'name' => 'Technology',
                'sub_categories' => [
                    ['id' => 401, 'name' => 'Mobile'],
                    ['id' => 402, 'name' => 'AI & Robotics'],
                    ['id' => 403, 'name' => 'Gadgets'],
                ]
            ],
            [
                'id' => 5, 
                'name' => 'Economy',
                'sub_categories' => [
                    ['id' => 501, 'name' => 'Stock Market'],
                    ['id' => 502, 'name' => 'Banking'],
                ]
            ],
            [
                'id' => 6, 
                'name' => 'Entertainment',
                'sub_categories' => [
                    ['id' => 601, 'name' => 'Movie'],
                    ['id' => 602, 'name' => 'Music'],
                    ['id' => 603, 'name' => 'Television'],
                ]
            ],
            [
                'id' => 7, 
                'name' => 'Health',
                'sub_categories' => [
                    ['id' => 701, 'name' => 'Fitness'],
                    ['id' => 702, 'name' => 'Nutrition'],
                ]
            ],
            [
                'id' => 8, 
                'name' => 'Education',
                'sub_categories' => [
                    ['id' => 801, 'name' => 'Admission'],
                    ['id' => 802, 'name' => 'Scholarship'],
                ]
            ],
            [
                'id' => 9, 
                'name' => 'Lifestyle',
                'sub_categories' => [
                    ['id' => 901, 'name' => 'Food'],
                    ['id' => 902, 'name' => 'Travel'],
                    ['id' => 903, 'name' => 'Fashion'],
                ]
            ],
            [
                'id' => 10, 
                'name' => 'Environment',
                'sub_categories' => []
            ],
            [
                'id' => 11, 
                'name' => 'Crime',
                'sub_categories' => []
            ],
            [
                'id' => 12, 
                'name' => 'Archive',
                'sub_categories' => []
            ],
        ];

        $divisions = ['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barisal', 'Sylhet', 'Rangpur', 'Mymensingh'];
        $districts = ['Dhaka', 'Gazipur', 'Narayanganj', 'Chittagong', 'Cox\'s Bazar', 'Sylhet'];

        return view('admin.posts.create', compact('categories', 'divisions', 'districts'));
    }
}
