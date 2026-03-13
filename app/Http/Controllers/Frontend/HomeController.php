<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Public homepage.
     */
    public function index(): View
    {
        // Use the imported frontend homepage from the original news-paper project.
        return view('welcome');
    }
}

