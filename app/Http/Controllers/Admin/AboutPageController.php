<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    use \App\Traits\ImageUploadTrait;

    public function index()
    {
        // Assuming singleton pattern for CompanyInfo
        $companyInfo = CompanyInfo::first();
        if (!$companyInfo) {
            $companyInfo = new CompanyInfo();
        }

        return view('admin.pages.about', compact('companyInfo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'history' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
        ]);

        $companyInfo = CompanyInfo::first();

        // Prepare data
        $data = $request->only([
            'company_name', 'email', 'phone', 'address', 'city', 'country',
            'mission', 'vision', 'history'
        ]);

        // Handle Image Upload
        if ($request->hasFile('about_image')) {
            $data['about_image'] = $this->updateImage($request->file('about_image'), 'company', $companyInfo ? $companyInfo->about_image : null);
        }

        if (!$companyInfo) {
            CompanyInfo::create($data);
        } else {
            $companyInfo->update($data);
        }

        return redirect()->route('admin.pages.about')->with('success', 'About Page content updated successfully.');
    }
}
