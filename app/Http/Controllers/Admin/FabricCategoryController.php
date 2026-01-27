<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FabricCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FabricCategoryController extends Controller
{
    public function index()
    {
        $categories = FabricCategory::latest()->paginate(10);
        return view('admin.fabric_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150|unique:fabric_categories',
            'status' => 'nullable|integer',
        ]);

        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        FabricCategory::create($validatedData);

        return redirect()->route('admin.fabric-categories.index')->with('success', 'Fabric Category created successfully.');
    }

    public function update(Request $request, FabricCategory $fabricCategory)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:fabric_categories,slug,' . $fabricCategory->id,
            'status' => 'nullable|integer',
        ]);

        $fabricCategory->update($validatedData);

        return redirect()->route('admin.fabric-categories.index')->with('success', 'Fabric Category updated successfully.');
    }

    public function destroy(FabricCategory $fabricCategory)
    {
        $fabricCategory->delete();
        return redirect()->route('admin.fabric-categories.index')->with('success', 'Fabric Category deleted successfully.');
    }

    public function ajaxStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150|unique:fabric_categories',
        ]);

        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        $category = FabricCategory::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Fabric Category created successfully',
            'category' => $category
        ]);
    }
}
