<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by read status
        if ($request->filled('status')) {
            $query->where('is_read', $request->status === 'read');
        }

        $contacts = $query->recent()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => Contact::count(),
            'unread' => Contact::unread()->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Display a contact message
     */
    public function show(Contact $contact)
    {
        // Mark as read when viewing
        if (!$contact->is_read) {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Toggle read status
     */
    public function toggleRead(Contact $contact)
    {
        if ($contact->is_read) {
            $contact->markAsUnread();
            $status = 'ditandai belum dibaca';
        } else {
            $contact->markAsRead();
            $status = 'ditandai sudah dibaca';
        }

        return back()->with('success', "Pesan berhasil {$status}!");
    }

    /**
     * Mark multiple contacts as read
     */
    public function markAllRead()
    {
        Contact::unread()->update(['is_read' => true]);
        return back()->with('success', 'Semua pesan ditandai sudah dibaca!');
    }

    /**
     * Delete a contact
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus!');
    }

    /**
     * Delete multiple contacts
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id',
        ]);

        Contact::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' pesan berhasil dihapus!');
    }
}
