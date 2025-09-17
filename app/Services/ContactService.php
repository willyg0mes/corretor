<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    /**
     * Create a new contact message
     */
    public function createContact(User $sender, User $receiver, Property $property, string $message, array $contactInfo = []): Contact
    {
        $contact = Contact::create([
            'property_id' => $property->id,
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'subject' => "Interesse no imóvel: {$property->title}",
            'message' => $message,
            'contact_info' => $contactInfo,
            'status' => Contact::STATUS_SENT,
        ]);

        // Send notification email
        $this->sendContactNotification($contact);

        return $contact;
    }

    /**
     * Send contact notification email
     */
    private function sendContactNotification(Contact $contact): void
    {
        try {
            // In a real application, you'd send an email here
            // Mail::to($contact->receiver->email)->send(new ContactNotification($contact));

            // For now, just log it
            \Log::info('Contact notification would be sent', [
                'contact_id' => $contact->id,
                'receiver_email' => $contact->receiver->email,
                'property_title' => $contact->property->title,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send contact notification: ' . $e->getMessage());
        }
    }

    /**
     * Get unread contacts count for user
     */
    public function getUnreadContactsCount(User $user): int
    {
        if ($user->isCorretor()) {
            return $user->receivedContacts()->where('status', Contact::STATUS_SENT)->count();
        }

        return 0;
    }

    /**
     * Mark contact as read
     */
    public function markAsRead(Contact $contact): void
    {
        if ($contact->status === Contact::STATUS_SENT) {
            $contact->update([
                'status' => Contact::STATUS_READ,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Mark contact as replied
     */
    public function markAsReplied(Contact $contact): void
    {
        $contact->update(['status' => Contact::STATUS_REPLIED]);

        // Could send a notification to the sender here
    }

    /**
     * Archive contact
     */
    public function archiveContact(Contact $contact): void
    {
        $contact->update(['status' => Contact::STATUS_ARCHIVED]);
    }

    /**
     * Get contacts statistics for user
     */
    public function getContactStats(User $user): array
    {
        if ($user->isCorretor()) {
            return [
                'total_received' => $user->receivedContacts()->count(),
                'unread' => $user->receivedContacts()->where('status', Contact::STATUS_SENT)->count(),
                'read' => $user->receivedContacts()->where('status', Contact::STATUS_READ)->count(),
                'replied' => $user->receivedContacts()->where('status', Contact::STATUS_REPLIED)->count(),
                'archived' => $user->receivedContacts()->where('status', Contact::STATUS_ARCHIVED)->count(),
            ];
        } else {
            return [
                'total_sent' => $user->sentContacts()->count(),
                'unread_responses' => 0, // Could be implemented if replies are tracked
            ];
        }
    }
}
