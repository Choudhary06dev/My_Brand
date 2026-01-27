<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class CompanyInfoController extends Controller
{
    use \App\Traits\ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyInfos = CompanyInfo::latest()->paginate(10);
        return view('admin.company_info.index', compact('companyInfos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.company_info.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'history' => 'nullable|string',
            'logo' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
        ]);

        CompanyInfo::create($validatedData);

        return redirect()->route('admin.company-info.index')->with('success', 'Company Info created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyInfo $companyInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyInfo $companyInfo)
    {
        return view('admin.company_info.edit', compact('companyInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyInfo $companyInfo)
    {
        $validatedData = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'history' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
        ]);

        $data = $validatedData;

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->updateImage($request->file('logo'), 'company', $companyInfo->logo);
        } else {
            unset($data['logo']); // Keep old logo if not uploaded
        }

        if ($request->hasFile('about_image')) {
            $data['about_image'] = $this->updateImage($request->file('about_image'), 'company', $companyInfo->about_image);
        } else {
            unset($data['about_image']); // Keep old about_image if not uploaded
        }

        $companyInfo->update($data);

        return redirect()->route('admin.company-info.index')->with('success', 'Company Info updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyInfo $companyInfo)
    {
        $companyInfo->delete();

        return redirect()->route('admin.company-info.index')->with('success', 'Company Info deleted successfully.');
    }
}
