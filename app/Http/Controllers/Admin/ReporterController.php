<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporterController extends Controller
{
    public function index()
    {
        return view('admin.reporters.index');
    }

    public function create()
    {
        return view('admin.reporters.create');
    }

    public function edit()
    {
        return view('admin.reporters.edit');
    }
}
