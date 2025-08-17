<?php
// app/Http/Controllers/Admin/ContactController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Mail\ContactNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Please check your input and try again.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'ip_address' => $request->ip(),
            ]);

            // Send email notification (optional) if MAIL_TO configured
            if (env('MAIL_TO')) {
                $this->sendNotificationEmail($contact);
            }

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! I will get back to you soon.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $query = Contact::query();
        
        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'unread') {
                $query->where('status', 'unread');
            } elseif ($request->status === 'read') {
                $query->where('status', 'read');
            }
        }
        
        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
        
        $contacts = $query->latest()->paginate(15);
        
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        // Mark as read when viewed
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:read,unread,replied'
        ]);
        
        $contact->update(['status' => $request->status]);
        
        return response()->json([
            'success' => true,
            'message' => 'Contact status updated successfully'
        ]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Contact message deleted successfully'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id'
        ]);
        
        Contact::whereIn('id', $request->ids)->delete();
        
        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' contact messages deleted successfully'
        ]);
    }

    private function sendNotificationEmail($contact)
    {
        try {
            $to = env('MAIL_TO');
            if ($to) {
                Mail::to($to)->send(new ContactNotification($contact));
            }
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send contact notification: ' . $e->getMessage());
        }
    }
}
