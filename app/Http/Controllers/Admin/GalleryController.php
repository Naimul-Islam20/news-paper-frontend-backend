<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return view('admin.galleries.index');
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function edit()
    {
        return view('admin.galleries.edit');
    }
}
