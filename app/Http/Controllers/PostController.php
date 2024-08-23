<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Source; 
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 25); 
        $sourceId = $request->input('source_id');

        $query = Post::query();

        if ($sourceId) {
            $query->where('source_id', $sourceId);
        }
    $query->orderBy('published_date', 'desc');

        $posts = $query->paginate($perPage);

        $sources = Source::all(); 

        return view('posts.index', compact('posts', 'sources', 'sourceId', 'perPage'));
    }
}
