<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = JobApplication::with('job')->latest()->paginate(10);
        return view('admin.job_applications.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobs = \App\Models\JobOpening::where('status', 1)->get();
        return view('admin.job_applications.create', compact('jobs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:job_openings,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:100',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string',
        ]);

        $data = $request->except('cv_file');

        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = $request->file('cv_file')->store('job_applications', 'public');
        }

        JobApplication::create($data);

        return redirect()->route('admin.job-applications.index')->with('success', 'Application created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(JobApplication $jobApplication)
    {
        // For modal details, loading job relationship
        $jobApplication->load('job');
        return response()->json($jobApplication);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplication $jobApplication)
    {
        $jobs = \App\Models\JobOpening::where('status', 1)->get();
        return view('admin.job_applications.edit', compact('jobApplication', 'jobs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobApplication $jobApplication)
    {
        $request->validate([
            'job_id' => 'required|exists:job_openings,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:100',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string',
        ]);

        $data = $request->except('cv_file');

        if ($request->hasFile('cv_file')) {
            // Delete old CV
            if ($jobApplication->cv_file) {
                Storage::disk('public')->delete($jobApplication->cv_file);
            }
            $data['cv_file'] = $request->file('cv_file')->store('job_applications', 'public');
        }

        $jobApplication->update($data);

        return redirect()->route('admin.job-applications.index')->with('success', 'Application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        if ($jobApplication->cv_file) {
            Storage::disk('public')->delete($jobApplication->cv_file);
        }

        $jobApplication->delete();

        return redirect()->route('admin.job-applications.index')->with('success', 'Application deleted successfully.');
    }
}
