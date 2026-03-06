<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Service;
use App\Models\Product;
use App\Models\Blog;
use App\Models\CompanyInfo;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)->orderBy('sequence')->get();
        $services = Service::where('status', 1)->orderBy('sequence')->get();
        $products = Product::where('status', 1)->latest()->get();
        $blogs = Blog::where('status', 1)->latest('published_at')->get();
        $categories = ProductCategory::whereNull('parent_id')->orderBy('sequence')->take(7)->get();
        $totalCategories = ProductCategory::whereNull('parent_id')->count();
        $company = CompanyInfo::first();

        return view('frontend.home', compact('sliders', 'services', 'products', 'blogs', 'company', 'categories', 'totalCategories'));
    }

    public function categories()
    {
        $categories = ProductCategory::whereNull('parent_id')->orderBy('sequence')->get();
        $company = CompanyInfo::first();
        return view('frontend.categories', compact('categories', 'company'));
    }

    public function products()
    {
        $company = CompanyInfo::first();
        $products = Product::where('status', 1)->with(['category', 'subcategory', 'childSubcategory'])->latest()->get();
        return view('frontend.products', compact('company', 'products'));
    }


    public function categoryDetail($slug)
    {
        $company = CompanyInfo::first();
        // Eager load parent chain for breadcrumbs
        $category = ProductCategory::where('slug', $slug)->with('parent.parent')->firstOrFail();

        // Check if this is a leaf node (subcategory with no children)
        $subcategories = ProductCategory::where('parent_id', $category->id)->get();

        // If no subcategories, it's a leaf node - fetch products but use the main category detail view
        $products = collect();
        if ($subcategories->count() === 0) {
            $products = Product::where(function ($query) use ($category) {
                $query->where('category_id', $category->id)
                    ->orWhere('subcategory_id', $category->id)
                    ->orWhere('child_subcategory_id', $category->id);
            })
                ->where('status', 1)
                ->latest()
                ->get();
        }

        // Just return the same consistent view
        return view('frontend.category-detail', compact('company', 'category', 'subcategories', 'products'));
    }

    public function saleProducts($slug = null)
    {
        $company = CompanyInfo::first();
        $query = Product::where('status', 1)->where('is_sale', 1)->with(['category', 'subcategory', 'childSubcategory']);

        $category = null;
        if ($slug) {
            $category = ProductCategory::where('slug', $slug)->firstOrFail();
            $query->where(function ($q) use ($category) {
                $q->where('category_id', $category->id)
                    ->orWhere('subcategory_id', $category->id)
                    ->orWhere('child_subcategory_id', $category->id);
            });
        }

        $products = $query->latest()->get();
        return view('frontend.sale-products', compact('company', 'products', 'category'));
    }

    public function about()
    {
        $company = CompanyInfo::first();
        // Fallback if no record
        if (!$company)
            $company = new CompanyInfo();

        return view('frontend.about', compact('company'));
    }


    public function companyShow($id = null)
    {
        $company = CompanyInfo::first(); // Layout data

        if ($id) {
            $targetCompany = CompanyInfo::findOrFail($id);
        } else {
            $targetCompany = $company; // Default to first company
            if (!$targetCompany) {
                return redirect()->route('home'); // Or handle empty state
            }
        }

        return view('frontend.company-detail', compact('company', 'targetCompany'));
    }

    public function services()
    {
        $company = CompanyInfo::first();
        $services = Service::where('status', 1)->orderBy('sequence')->get();
        return view('frontend.services', compact('company', 'services'));
    }

    public function serviceDetail($slug)
    {
        $company = CompanyInfo::first();
        $singleService = Service::where('slug', $slug)->firstOrFail();
        $otherServices = Service::where('status', 1)->where('id', '!=', $singleService->id)->orderBy('sequence')->take(5)->get();
        return view('frontend.services', compact('company', 'singleService', 'otherServices'));
    }

    public function careers()
    {
        $company = CompanyInfo::first();
        return view('frontend.careers', compact('company'));
    }

    public function news()
    {
        $company = CompanyInfo::first();
        $blogs = Blog::with('author')->where('status', 1)->latest('published_at')->paginate(9);
        return view('frontend.news', compact('company', 'blogs'));
    }

    public function newsDetail($id)
    {
        $company = CompanyInfo::first();
        $singleBlog = Blog::with('author')->findOrFail($id);
        $recentBlogs = Blog::where('status', 1)->where('id', '!=', $id)->latest('published_at')->take(5)->get();
        return view('frontend.news', compact('company', 'singleBlog', 'recentBlogs'));
    }

    public function productDetail($slug)
    {
        $company = CompanyInfo::first();
        $product = Product::where('slug', $slug)->with([
            'category.parent.parent',
            'subcategory.parent.parent',
            'childSubcategory.parent.parent',
            'galleries',
            'fabricCategory',
            'fabric'
        ])->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.product-detail', compact('company', 'product', 'relatedProducts'));
    }

    public function contact()
    {
        $company = CompanyInfo::first();
        return view('frontend.contact', compact('company'));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\ContactMessage::create($request->all());

        return redirect()->back()->with('success', 'Your message has been sent successfully. We will get back to you soon.');
    }
}
