<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Nilambar\NepaliDate\NepaliDate;

class NewsController extends Controller
{
    protected $nepaliDate;


    public function index(Request $request)
    {
        // Fetch filters
        $sourceId = $request->input('source_id');
        $publishedFrom = $request->input('published_from');
        $publishedTo = $request->input('published_to');

        $query = Post::with('source'); 

        if ($sourceId) {
            $query->where('source_id', $sourceId);
        }

        if ($publishedFrom) {
            $query->where('published_date', '>=', $publishedFrom);
        }

        if ($publishedTo) {
            $query->where('published_date', '<=', $publishedTo);
        }

        $posts = $query->orderBy('published_date', 'desc')->paginate(20); 


        $posts->transform(function ($post) {
            $post->news_overview = Str::limit($this->cleanText($post->news_overview), 100, '...');
            $post->title = $this->cleanText($post->title);
            $post->nepali_date = $this->convertToNepaliDate($post->published_date);
            return $post;
        });

        $sources = Source::all();

        return view('news.index', compact('posts', 'sources', 'sourceId', 'publishedFrom', 'publishedTo'));
    }

    public function loadMore(Request $request)
    {
        $page = $request->input('page', 1);
        $sourceId = $request->input('source_id');
        $publishedFrom = $request->input('published_from');
        $publishedTo = $request->input('published_to');

        $query = Post::with('source')
            ->orderBy('published_date', 'desc'); // Sort by published_date

        if ($sourceId) {
            $query->where('source_id', $sourceId);
        }

        if ($publishedFrom) {
            $query->where('published_date', '>=', $publishedFrom);
        }

        if ($publishedTo) {
            $query->where('published_date', '<=', $publishedTo);
        }

        $posts = $query->paginate(20, ['*'], 'page', $page + 1);

        // Clean up and truncate the news overview and title
        $posts->transform(function ($post) {
            $post->news_overview = Str::limit($this->cleanText($post->news_overview), 100, '...');
            $post->title = $this->cleanText($post->title);
            $post->nepali_date = $this->convertToNepaliDate($post->published_date);
            return $post;
        });

        return view('news._posts', [
            'posts' => $posts,
            'sourceId' => $sourceId,
            'publishedFrom' => $publishedFrom,
            'publishedTo' => $publishedTo
        ]);
    }

    protected function cleanText($text)
    {
        $text = htmlspecialchars_decode($text);

        $text = strip_tags($text);

        $text = preg_replace('/\s+/', ' ', $text); 
        $text = preg_replace('/&nbsp;|&#8216;/', '', $text); 

        return $text;
    }

  protected function convertToNepaliDate($date)
{
    $obj = new NepaliDate();

    // Check if date includes time
    $dateParts = explode(' ', $date);
    $dateOnly = $dateParts[0]; 
        $dateParts = explode('-', $dateOnly);
    $adYear = $dateParts[0];
    $adMonth = $dateParts[1];
    $adDay = $dateParts[2];
    // Convert AD to BS
    $nepaliDate = $obj->getDetails($adYear, $adMonth, $adDay,'ad');

    return $nepaliDate;
}

}
