<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medias = Media::all();

        return Inertia::render('Medias/Index', [
            'medias' => $medias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'link' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        Media::create($validated);

        return redirect()->route('abouts.index')->with('success', 'Media link created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $media = Media::findOrFail($id);

        $validated = $request->validate([
            'link' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        $media->update($validated);

        return redirect()->route('abouts.index')->with('success', 'Media link updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $media = Media::findOrFail($id);
        $media->delete();

        return redirect()->route('abouts.index')->with('success', 'Media link deleted successfully.');
    }
}
