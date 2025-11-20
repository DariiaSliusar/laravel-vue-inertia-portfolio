<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = About::first();

        return Inertia::render('Abouts/Index', [
            'about' => $about,
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
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'summary' => 'nullable|string',
            'tagline' => 'nullable|string',
            'home_image' => 'nullable|image|max:2048',
            'banner_image' => 'nullable|image|max:2048',
            'cv' => 'nullable|mimes:pdf|max:5120',
        ]);

        // Handle file uploads
        if ($request->hasFile('home_image')) {
            $validated['home_image'] = $request->file('home_image')->store('images/about', 'public');
        }

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('images/about', 'public');
        }

        if ($request->hasFile('cv')) {
            $validated['cv'] = $request->file('cv')->store('cv', 'public');
        }

        About::create($validated);

        return redirect()->route('abouts.index')->with('success', 'About information created successfully.');
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
        $about = About::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'summary' => 'nullable|string',
            'tagline' => 'nullable|string',
            'home_image' => 'nullable|image|max:2048',
            'banner_image' => 'nullable|image|max:2048',
            'cv' => 'nullable|mimes:pdf|max:5120',
        ]);

        // Handle file uploads
        if ($request->hasFile('home_image')) {
            $validated['home_image'] = $request->file('home_image')->store('images/about', 'public');
        }

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('images/about', 'public');
        }

        if ($request->hasFile('cv')) {
            $validated['cv'] = $request->file('cv')->store('cv', 'public');
        }

        $about->update($validated);

        return redirect()->route('abouts.index')->with('success', 'About information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
