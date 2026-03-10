<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    public function visitors()
    {
        return view('admin.statistics.visitors');
    }
}
