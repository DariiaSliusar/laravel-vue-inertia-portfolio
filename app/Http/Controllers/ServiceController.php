<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::query()->get();
        return Inertia::render('Services/Index', [
            'services' => $services,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Services/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'icon' => 'required',
            'description' => 'required',
        ]);

        Service::query()->create([
            'title' => $request->title,
            'icon' => $request->icon,
            'description' => $request->description,
        ]);

        return redirect()->route("services.index")->with('success', 'Service created successfully.');
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
        $service = Service::query()->find($id);
        return Inertia::render('Services/Edit', [
            'service' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'icon' => 'required',
            'description' => 'required',
        ]);

        $service = Service::query()->find($id);

        $service->update($validated);

        return redirect()->route("services.index")->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::query()->find($id);
        $service->delete();

        return redirect()->route("services.index")->with('success', 'Service deleted successfully.');
    }
}
