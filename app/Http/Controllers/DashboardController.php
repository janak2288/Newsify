<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Source;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetching details
        $totalPosts = Post::count();
        $totalSources = Source::count();


        return view('dashboard', compact('totalPosts', 'totalSources'));
    }
}
