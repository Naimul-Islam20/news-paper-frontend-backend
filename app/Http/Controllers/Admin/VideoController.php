<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        return view('admin.videos.index');
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function edit()
    {
        return view('admin.videos.edit');
    }
}
