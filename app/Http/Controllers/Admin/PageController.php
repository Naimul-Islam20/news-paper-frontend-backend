<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        // Placeholder for All Pages
        return view('admin.pages.index');
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }
}
