<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Strategy;

class MetricController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $strategies = Strategy::all();

        return view('metrics.index', compact('categories', 'strategies'));
    }
}