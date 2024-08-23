<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Source;
use Illuminate\Support\Facades\Storage;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        $logoPath = $request->file('logo') ? $request->file('logo')->store('public/logos') : null;

        Source::create([
            'name' => $request->name,
            'json_url' => $request->json_url,
            'logo' => $logoPath,
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

        $logoPath = $request->file('logo') ? $request->file('logo')->store('public/logos') : $source->logo;

        $source->update([
            'name' => $request->name,
            'json_url' => $request->json_url,
            'logo' => $logoPath,
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
