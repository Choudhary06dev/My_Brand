<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOpening;
use Illuminate\Http\Request;

class JobOpeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobOpenings = JobOpening::latest()->paginate(10);
        return view('admin.job_openings.index', compact('jobOpenings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.job_openings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        JobOpening::create($request->all());

        return redirect()->route('admin.job-openings.index')->with('success', 'Job opening created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobOpening $jobOpening)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOpening $jobOpening)
    {
        return view('admin.job_openings.edit', compact('jobOpening'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobOpening $jobOpening)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $jobOpening->update($request->all());

        return redirect()->route('admin.job-openings.index')->with('success', 'Job opening updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOpening $jobOpening)
    {
        $jobOpening->delete();

        return redirect()->route('admin.job-openings.index')->with('success', 'Job opening deleted successfully.');
    }
}
