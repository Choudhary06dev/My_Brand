<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\FabricCategory;
use App\Models\Fabric;

class ProductController extends Controller
{
    use \App\Traits\ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'subcategory', 'childSubcategory'])
            ->withCount('galleries')
            ->latest()
            ->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::whereNull('parent_id')->get();
        $fabricCategories = FabricCategory::where('status', 1)->get();
        return view('admin.products.create', compact('categories', 'fabricCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_type' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:product_categories,id',
            'subcategory_id' => 'nullable|exists:product_categories,id',
            'child_subcategory_id' => 'nullable|exists:product_categories,id',
            'price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'special_effects' => 'nullable|string|max:255',
            'washing_dyeing_category' => 'nullable|string|max:255',
            'fabric_category_id' => 'nullable|exists:fabric_categories,id',
            'fabric_id' => 'nullable|exists:fabrics,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'status' => 'boolean',
            'is_sale' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = $this->generateUniqueSlug($request->product_name);
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['is_sale'] = $request->has('is_sale') ? 1 : 0;

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $this->uploadImage($request->file('main_image'), 'products');
        }

        $product = Product::create($data);

        // Handle Gallery Images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $this->uploadImage($image, 'product_galleries');
                \App\Models\ProductGallery::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::whereNull('parent_id')->get();
        $fabricCategories = FabricCategory::where('status', 1)->get();
        $fabrics = [];
        if ($product->fabric_category_id) {
            $fabrics = Fabric::where('fabric_category_id', $product->fabric_category_id)->where('status', 1)->get();
        }
        return view('admin.products.edit', compact('product', 'categories', 'fabricCategories', 'fabrics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_type' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:product_categories,id',
            'subcategory_id' => 'nullable|exists:product_categories,id',
            'child_subcategory_id' => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'special_effects' => 'nullable|string|max:255',
            'washing_dyeing_category' => 'nullable|string|max:255',
            'fabric_category_id' => 'nullable|exists:fabric_categories,id',
            'fabric_id' => 'nullable|exists:fabrics,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'status' => 'boolean',
            'is_sale' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = $this->generateUniqueSlug($request->product_name, $product->id);

        // Handle checkbox for status (if unchecked it's absent from request)
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['is_sale'] = $request->has('is_sale') ? 1 : 0;

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $this->updateImage($request->file('main_image'), 'products', $product->main_image);
        }

        $product->update($data);

        // Handle Gallery Images (Append new ones)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $this->uploadImage($image, 'product_galleries');
                \App\Models\ProductGallery::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete main image
        $this->deleteImage($product->main_image);

        // Delete gallery images
        foreach ($product->galleries as $gallery) {
            $this->deleteImage($gallery->image_path);
            $gallery->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Delete a specific gallery image.
     */
    public function deleteGalleryImage($id)
    {
        try {
            $gallery = \App\Models\ProductGallery::findOrFail($id);

            $this->deleteImage($gallery->image_path);

            $gallery->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gallery image deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate a unique slug for the product.
     *
     * @param string $name
     * @param int|null $ignoreId
     * @return string
     */
    private function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Check if slug exists
        while (Product::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
