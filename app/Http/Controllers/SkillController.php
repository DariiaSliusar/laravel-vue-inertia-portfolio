<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Skill;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::with('service')->get();
        return Inertia::render('Skills/Index', [
            'skills' => $skills,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return Inertia::render('Skills/Create', [
            'services' => $services,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'proficiency' => 'required|integer|min:0|max:100',
            'service_id' => 'required|exists:services,id',
        ]);

        Skill::query()->create($validated);

        return redirect()->route('skills.index');
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
        $skill = Skill::query()->findOrFail($id);
        $services = Service::all();

        return Inertia::render('Skills/Edit', [
            'skill' => $skill,
            'services' => $services,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'proficiency' => 'required|integer|min:0|max:100',
            'service_id' => 'required|exists:services,id',
        ]);

        $skill = Skill::query()->findOrFail($id);
        $skill->update($validated);

        return redirect()->route('skills.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $skill = Skill::query()->findOrFail($id);
        $skill->delete();

        return redirect()->route('skills.index');
    }
}
