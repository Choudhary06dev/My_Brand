<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Always show top-level categories, but eager load children for the modal
        $categories = ProductCategory::with('children')->whereNull('parent_id')->latest()->paginate(10);

        return view('admin.product_categories.index', compact('categories'));
    }

    public function subIndex(Request $request)
    {
        $categories = ProductCategory::with('parent')->whereNotNull('parent_id')->latest()->paginate(10);
        return view('admin.product_categories.sub_index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::whereNull('parent_id')->get();
        return view('admin.product_categories.create', compact('categories'));
    }

    public function getSubcategories($id)
    {
        $subcategories = ProductCategory::where('parent_id', $id)->get();
        return response()->json($subcategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:product_categories',
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'sequence' => 'nullable|integer',
        ]);

        if ($request->missing('slug') || is_null($request->slug)) {
            $validatedData['slug'] = Str::slug($validatedData['category_name']);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $validatedData['image'] = $imagePath;
        }

        ProductCategory::create($validatedData);

        return redirect()->route('admin.product-categories.index')->with('success', 'Product Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        $categories = ProductCategory::whereNull('parent_id')->where('id', '!=', $productCategory->id)->get();
        return view('admin.product_categories.edit', compact('productCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:product_categories,slug,' . $productCategory->id,
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'sequence' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($productCategory->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($productCategory->image);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
            $validatedData['image'] = $imagePath;
        }

        $productCategory->update($validatedData);

        return redirect()->route('admin.product-categories.index')->with('success', 'Product Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($productCategory->image);
        }
        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')->with('success', 'Product Category deleted successfully.');
    }
    public function ajaxStore(Request $request)
    {
        $rules = [
            'category_name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150|unique:product_categories',
            'parent_id' => 'required|exists:product_categories,id',
            'sequence' => 'nullable|integer',
        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072';
        }

        $validatedData = $request->validate($rules);

        if ($request->missing('slug') || is_null($request->slug) || empty($request->slug)) {
            $validatedData['slug'] = Str::slug($validatedData['category_name']);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $validatedData['image'] = $imagePath;
        }

        $subcategory = ProductCategory::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Subcategory created successfully',
            'subcategory' => $subcategory
        ]);
    }

    public function ajaxUpdate(Request $request, $id)
    {
        $subcategory = ProductCategory::findOrFail($id);

        $rules = [
            'category_name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:product_categories,slug,' . $id,
            'sequence' => 'nullable|integer',
        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072';
        }

        $validatedData = $request->validate($rules);

        if ($request->missing('slug') || is_null($request->slug) || empty($request->slug)) {
            $validatedData['slug'] = Str::slug($validatedData['category_name']);
        }

        if ($request->hasFile('image')) {
            if ($subcategory->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($subcategory->image);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
            $validatedData['image'] = $imagePath;
        }

        $subcategory->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Subcategory updated successfully',
            'subcategory' => $subcategory
        ]);
    }

    public function ajaxDestroy($id)
    {
        $subcategory = ProductCategory::findOrFail($id);

        if ($subcategory->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($subcategory->image);
        }

        $subcategory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subcategory deleted successfully'
        ]);
    }
}
