<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdvertisementController extends Controller
{
    public function index()
    {
        return view('admin.advertisements.index');
    }

    public function create()
    {
        return view('admin.advertisements.create');
    }

    public function edit()
    {
        return view('admin.advertisements.edit');
    }
}
