<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Source;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\Post;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */


public function show(Source $source)
{
    // Fetch JSON data from the source's URL
    $jsonData = $this->fetchJsonData($source->json_url);

    if ($jsonData === null) {
        return redirect()->back()->with('error', 'Failed to fetch data from the JSON URL.');
    }

    // Store the fetched data into the database
    $this->storeJsonData($jsonData, $source->id);

    // Redirect back with a success message
    return redirect()->route('sources.index')
                     ->with('success', 'Data successfully fetched and stored.');
}


private function fetchJsonData($url)
{
    try {
        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    } catch (\Exception $e) {
        // Handle the exception
        return null;
    }
}

private function storeJsonData(array $jsonData, $sourceId)
{
    foreach ($jsonData as $item) {
        $dateTime = new \DateTime($item['publishedDate']);
        $formattedDate = $dateTime->format('Y-m-d H:i:s'); 
        $postData = [
            'source_id' => $sourceId,
            'title' => $item['title'],
            'news_url' => $item['newsUrl'],
            'thumbnail_url' => $item['thumbnailUrl'] ?? null,
            'news_overview' => $item['newsOverView'],
            'published_date' => $formattedDate
        ];

        Post::updateOrCreate(
            ['news_url' => $postData['news_url']],
            $postData
        );
    }
}





    public function index()
    {
        $sources = Source::all();
        return view('sources.index', compact('sources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'json_url' => 'required|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

       $logoPath = $request->file('logo') 
        ? $request->file('logo')->store('public/logos') 
        : $source->logo;

    $logoUrl = $logoPath ? Storage::url($logoPath) : $source->logo;

        Source::create([
            'name' => $request->name,
            'json_url' => $request->json_url,
            'logo' => $logoUrl,
        ]);

        return redirect()->route('sources.index')->with('success', 'Source created successfully.');
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source)
    {
        return view('sources.edit', compact('source'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Source $source)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'json_url' => 'required|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


$logoPath = $request->file('logo') 
        ? $request->file('logo')->store('public/logos') 
        : $source->logo;

    $logoUrl = $logoPath ? Storage::url($logoPath) : $source->logo;

        $source->update([
            'name' => $request->name,
            'json_url' => $request->json_url,
            'logo' => $logoUrl,
        ]);

        return redirect()->route('sources.index')->with('success', 'Source updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Source $source)
    {
        if ($source->logo) {
            Storage::delete($source->logo);
        }

        $source->delete();

        return redirect()->route('sources.index')->with('success', 'Source deleted successfully.');
    }
}
