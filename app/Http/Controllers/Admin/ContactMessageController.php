<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(10);
        return view('admin.contact_messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact_messages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'is_read' => 'boolean',
        ]);

        ContactMessage::create($request->all());

        return redirect()->route('admin.contact-messages.index')->with('success', 'Contact message created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $contactMessage)
    {
        // This won't be used directly by the modal as we pass JSON, 
        // but can be used if we want to mark as read when viewed via AJAX details.
        // For now, simple view.
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }
        return response()->json($contactMessage);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactMessage $contactMessage)
    {
        return view('admin.contact_messages.edit', compact('contactMessage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'is_read' => 'boolean',
        ]);

        $contactMessage->update($request->all());

        return redirect()->route('admin.contact-messages.index')->with('success', 'Contact message updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }

    /**
     * Mark the specified resource as replied.
     */
    /**
     * Send reply email and save it.
     */
    public function sendReply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required|string',
        ]);

        $message = ContactMessage::findOrFail($id);

        // Update database
        $message->update([
            'reply_message' => $request->reply_message,
            'replied_at' => now(),
        ]);

        // Send Email
        try {
            Mail::to($message->email)->send(new ContactReplyMail($message, $request->reply_message));
        } catch (\Exception $e) {
            // Log error or ignore if mail is not configured
        }

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }
}
