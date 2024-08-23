<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ClickController extends Controller
{
    public function redirectToNewsUrl($id, Request $request)
    {
        $post = Post::findOrFail($id);
        $referer = $request->headers->get('referer');
        $userAgent = $request->headers->get('User-Agent');

        return redirect()->away($post->news_url, 301)->header('Referer', $referer);
    }
}
