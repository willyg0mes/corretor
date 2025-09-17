<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Property;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Show the form for creating a new contact
     */
    public function create(Property $property)
    {
        return view('contacts.create', compact('property'));
    }

    /**
     * Display a listing of contacts for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isCorretor()) {
            $contacts = $user->receivedContacts()->with(['property', 'sender'])->paginate(15);
        } else {
            $contacts = $user->sentContacts()->with(['property', 'receiver'])->paginate(15);
        }

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Store a new contact message
     */
    public function store(Request $request, Property $property)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        $contact = $this->contactService->createContact(
            Auth::user(),
            $property->user,
            $property,
            $validated['message'],
            $validated
        );

        return redirect()->back()->with('success', 'Mensagem enviada com sucesso!');
    }

    /**
     * Display the specified contact
     */
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        if (Auth::id() === $contact->receiver_id) {
            $contact->markAsRead();
        }

        return view('contacts.show', compact('contact'));
    }

    /**
     * Mark contact as replied
     */
    public function markAsReplied(Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->markAsReplied();

        return redirect()->back()->with('success', 'Contato marcado como respondido');
    }

    /**
     * Archive contact
     */
    public function archive(Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update(['status' => Contact::STATUS_ARCHIVED]);

        return redirect()->back()->with('success', 'Contato arquivado');
    }
}
