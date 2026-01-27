<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = EmailTemplate::latest()->paginate(10);
        return view('admin.email_templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.email_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:email_templates',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'variables' => 'nullable|string', // Taking as comma-separated string for simplicity in input, or handle detailed JSON
        ]);

        // Convert variables string to array if needed, or just store purely
        // simpler to just accept optional JSON or text describing variables

        // If user inputs "name, email", we can split it.
        if ($request->filled('variables')) {
            $validatedData['variables'] = array_map('trim', explode(',', $request->variables));
        }

        EmailTemplate::create($validatedData);

        return redirect()->route('admin.email-templates.index')->with('success', 'Email Template created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailTemplate $emailTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email_templates.edit', compact('emailTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:email_templates,name,' . $emailTemplate->id,
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'variables' => 'nullable|string',
        ]);

        if ($request->filled('variables')) {
            $validatedData['variables'] = array_map('trim', explode(',', $request->variables));
        }

        $emailTemplate->update($validatedData);

        return redirect()->route('admin.email-templates.index')->with('success', 'Email Template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return redirect()->route('admin.email-templates.index')->with('success', 'Email Template deleted successfully.');
    }
}
