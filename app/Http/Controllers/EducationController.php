<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $educations = Education::query()->get();
        return Inertia::render('Educations/Index', [
            'educations' => $educations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Educations/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'department' => 'required|string|max:255',
        ]);

        Education::query()->create($validated);

        return redirect()->route('educations.index')->with('success', 'Education created successfully.');
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
        $education = Education::query()->findOrFail($id);
        return Inertia::render('Educations/Edit', [
            'education' => $education,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'department' => 'required|string|max:255',
        ]);

        $education = Education::query()->findOrFail($id);
        $education->update($validated);

        return redirect()->route('educations.index')->with('success', 'Education updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $education = Education::query()->findOrFail($id);
        $education->delete();

        return redirect()->route('educations.index')->with('success', 'Education deleted successfully.');
    }
}
