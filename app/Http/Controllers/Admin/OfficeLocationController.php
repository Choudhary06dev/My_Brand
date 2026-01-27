<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficeLocation;
use Illuminate\Http\Request;

class OfficeLocationController extends Controller
{
    public function index()
    {
        $officeLocations = OfficeLocation::orderBy('sequence')->latest()->paginate(10);
        return view('admin.office_locations.index', compact('officeLocations'));
    }

    public function create()
    {
        return view('admin.office_locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'sequence' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        OfficeLocation::create($validated);
        return redirect()->route('admin.office-locations.index')->with('success', 'Office location created successfully.');
    }

    public function edit(OfficeLocation $officeLocation)
    {
        return view('admin.office_locations.edit', compact('officeLocation'));
    }

    public function update(Request $request, OfficeLocation $officeLocation)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'sequence' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $officeLocation->update($validated);
        return redirect()->route('admin.office-locations.index')->with('success', 'Office location updated successfully.');
    }

    public function destroy(OfficeLocation $officeLocation)
    {
        $officeLocation->delete();

        return redirect()->route('admin.office-locations.index')->with('success', 'Office location deleted successfully.');
    }
}
