<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fabric;
use App\Models\FabricCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FabricController extends Controller
{
    public function index()
    {
        $fabrics = Fabric::with('category')->latest()->paginate(10);
        $categories = FabricCategory::where('status', 1)->get();
        return view('admin.fabrics.index', compact('fabrics', 'categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150|unique:fabrics',
            'fabric_category_id' => 'required|exists:fabric_categories,id',
            'status' => 'nullable|integer',
        ]);

        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        Fabric::create($validatedData);

        return redirect()->route('admin.fabrics.index')->with('success', 'Fabric created successfully.');
    }

    public function update(Request $request, Fabric $fabric)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:fabrics,slug,' . $fabric->id,
            'fabric_category_id' => 'required|exists:fabric_categories,id',
            'status' => 'nullable|integer',
        ]);

        $fabric->update($validatedData);

        return redirect()->route('admin.fabrics.index')->with('success', 'Fabric updated successfully.');
    }

    public function destroy(Fabric $fabric)
    {
        $fabric->delete();
        return redirect()->route('admin.fabrics.index')->with('success', 'Fabric deleted successfully.');
    }

    public function getFabricsByCategory($categoryId)
    {
        $fabrics = Fabric::where('fabric_category_id', $categoryId)->where('status', 1)->get();
        return response()->json($fabrics);
    }
}
