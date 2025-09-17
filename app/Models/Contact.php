<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'sender_id',
        'receiver_id',
        'subject',
        'message',
        'status',
        'contact_info',
        'read_at',
    ];

    protected $casts = [
        'contact_info' => 'array',
        'read_at' => 'datetime',
    ];

    // Constants
    const STATUS_SENT = 'sent';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';
    const STATUS_ARCHIVED = 'archived';

    /**
     * Get the property that the contact is about
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the sender (client)
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver (agent)
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Mark as read
     */
    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update([
                'status' => self::STATUS_READ,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Mark as replied
     */
    public function markAsReplied(): void
    {
        $this->update(['status' => self::STATUS_REPLIED]);
    }

    /**
     * Check if message is unread
     */
    public function isUnread(): bool
    {
        return $this->status === self::STATUS_SENT;
    }
}
