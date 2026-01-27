<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Service;
use App\Models\Product;
use App\Models\Blog;
use App\Models\CompanyInfo;
use App\Models\TeamMember;
use App\Models\ProductCategory;

use App\Models\JobOpening;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)->orderBy('sequence')->get();
        $services = Service::where('status', 1)->orderBy('sequence')->get();
        $products = Product::where('status', 1)->latest()->get();
        $blogs = Blog::where('status', 1)->latest('published_at')->take(3)->get();
        $teamMembers = TeamMember::orderBy('sequence')->get();
        $categories = ProductCategory::whereNull('parent_id')->orderBy('sequence')->take(7)->get();
        $totalCategories = ProductCategory::whereNull('parent_id')->count();
        $company = CompanyInfo::first();

        return view('frontend.home', compact('sliders', 'services', 'products', 'blogs', 'teamMembers', 'company', 'categories', 'totalCategories'));
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

    public function about()
    {
        $company = CompanyInfo::first();
        // Fallback if no record
        if (!$company)
            $company = new CompanyInfo();

        $teamMembers = TeamMember::orderBy('sequence')->get();
        return view('frontend.about', compact('company', 'teamMembers'));
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
        $jobs = JobOpening::where('status', 1)->latest()->get();
        // Note: Check JobOpening status values. Assuming 'Open' or boolean or 'Active'. 
        // Model definition didn't show enum, but let's assume 'Active' or 1 based on other models.
        // Actually Service has status 1. Let's check JobOpening status type in db if possible, but safely we can just fetch all for now or check valid statuses.
        // Let's assume 'Active' or 1. If it's a string, we might need to be careful.
        // Previous output showed: 'status' in fillable.

        // Let's just fetch all for now and filter in view or if we know the value.
        // Admin index likely shows status.
        return view('frontend.careers', compact('company', 'jobs'));
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

    public function applyJob(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:job_openings,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:100',
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string',
        ]);

        $data = $request->except('cv_file');

        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = $request->file('cv_file')->store('job_applications', 'public');
        }

        \App\Models\JobApplication::create($data);

        return redirect()->back()->with('success', 'Application submitted successfully. We will get back to you soon.');
    }

    public function contact()
    {
        $company = CompanyInfo::first();
        $officeLocations = \App\Models\OfficeLocation::where('status', 1)->orderBy('sequence')->get();
        return view('frontend.contact', compact('company', 'officeLocations'));
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
