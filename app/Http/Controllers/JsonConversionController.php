<?php

namespace App\Http\Controllers;

use App\Models\JsonConversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JsonConversionController extends Controller
{


 public function show($id)
    {
        // Find the JSON conversion entry by ID
        $jsonConversion = JsonConversion::findOrFail($id);

        // Fetch JSON data from the provided URL
        $response = Http::get($jsonConversion->url);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();

            // Initialize the converted data array
            $convertedData = [];

            // Check if the type is 'wordpress_with_jetpack' and convert accordingly
            if ($jsonConversion->type === 'wordpress_with_jetpack') {
                foreach ($data as $item) {
                    // Convert each item to the desired format
                    $convertedData[] = [
                        'title' => $item['title']['rendered'] ?? null,
                        'newsUrl' => $item['link'] ?? null,
                        'thumbnailUrl' => $item['jetpack_featured_media_url'] ?? null,
                        'newsOverView' => $item['excerpt']['rendered'] ?? null,
                        'publishedDate' => $item['date'] ?? null,
                    ];
                }
            }
              if ($jsonConversion->type === 'wordpress_without_jetpack') {
        foreach ($data as $item) {
            $convertedData[] = [
                'title' => $item['title']['rendered'] ?? null,
                'newsUrl' => $item['link'] ?? null,
                'thumbnailUrl' => $this->getThumbnailUrl($item),
                'newsOverView' => $item['excerpt']['rendered'] ?? null,
                'publishedDate' => $item['date'] ?? null,
            ];
        }
    }

            // Add other conversions based on type if needed

            // Return the converted data as JSON
            return response()->json($convertedData);
        }

        // Handle failed request
        return response()->json(['error' => 'Failed to fetch data'], 500);
    }

private function getThumbnailUrl($item)
{
    // Extract thumbnail URL from the JSON item
    if (isset($item['_links']['wp:featuredmedia'][0]['href'])) {
        $mediaData = $this->fetchMediaData($item['_links']['wp:featuredmedia'][0]['href']);
        return $mediaData['guid']['rendered'] ?? null;
    }
    return null;
}

private function fetchMediaData($url)
{
    // Fetch media data from the provided URL
    $response = Http::get($url);
    return $response->json();
}




    // Display the form for adding a new entry
    public function create()
    {
        return view('json.create');
    }

    // Store the newly created entry
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'type' => 'required|string',
        ]);

        // Store the data in the database
        JsonConversion::create([
            'name' => $request->input('name'),
            'url' => $request->input('url'),
            'type' => $request->input('type'),
        ]);

        return redirect()->route('json-conversion.index')->with('success', 'Data stored successfully!');
    }

    // Display a list of all entries with the option to edit
    public function index()
    {
        $conversions = JsonConversion::paginate(25); // Change the pagination as needed

        return view('json.index', compact('conversions'));
    }

    // Display the form for editing an existing entry
    public function edit($id)
    {
        $conversion = JsonConversion::findOrFail($id);

        return view('json.edit', compact('conversion'));
    }

    // Update the existing entry
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'type' => 'required|string',
        ]);

        // Find the existing record and update it
        $conversion = JsonConversion::findOrFail($id);
        $conversion->update([
            'name' => $request->input('name'),
            'url' => $request->input('url'),
            'type' => $request->input('type'),
        ]);

        return redirect()->route('json-conversion.index')->with('success', 'Data updated successfully!');
    }
}
