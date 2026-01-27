<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use \App\Traits\ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with('author')->latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            // 'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'status' => 'required|boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->except(['thumbnail', 'banner_image']);
        $data['slug'] = Str::slug($request->title);
        $data['author_id'] = Auth::id();

        // Thumbnail is now same as banner
        if ($request->hasFile('banner_image')) {
            $path = $this->uploadImage($request->file('banner_image'), 'blogs/banners');
            $data['banner_image'] = $path;
            $data['thumbnail'] = $path;
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            // 'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'status' => 'required|boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->except(['thumbnail', 'banner_image']);

        // Only update slug if title changed, or keep it same. 
        // For SEO, usually better to keep old slug unless explicitly changing.
        if ($blog->title !== $request->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // Thumbnail is now same as banner
        if ($request->hasFile('banner_image')) {
            // Delete old banner
            $this->deleteImage($blog->banner_image);
            
            // Only delete thumbnail if it's a different file (legacy support)
            if ($blog->thumbnail && $blog->thumbnail !== $blog->banner_image) {
                $this->deleteImage($blog->thumbnail);
            }

            $path = $this->uploadImage($request->file('banner_image'), 'blogs/banners');
            $data['banner_image'] = $path;
            $data['thumbnail'] = $path;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->thumbnail)
            $this->deleteImage($blog->thumbnail);
        if ($blog->banner_image)
            $this->deleteImage($blog->banner_image);

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully.');
    }
}
