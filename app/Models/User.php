<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'creci',
        'bio',
        'preferences',
        'is_active',
        'last_login_at',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'creci', // Hide CRECI for non-admins
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    // Role constants
    const ROLE_CLIENTE = 'cliente';
    const ROLE_CORRETOR = 'corretor';
    const ROLE_ADMIN = 'admin';

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is real estate agent
     */
    public function isCorretor(): bool
    {
        return $this->role === self::ROLE_CORRETOR;
    }

    /**
     * Check if user is client
     */
    public function isCliente(): bool
    {
        return $this->role === self::ROLE_CLIENTE;
    }

    /**
     * Get user's properties (for agents)
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Get user's favorites
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get contacts sent by user (client messages)
     */
    public function sentContacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'sender_id');
    }

    /**
     * Get contacts received by user (agent messages)
     */
    public function receivedContacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'receiver_id');
    }

    /**
     * Get visits scheduled by user (client visits)
     */
    public function scheduledVisits(): HasMany
    {
        return $this->hasMany(Visit::class, 'client_id');
    }

    /**
     * Get visits received by user (agent visits)
     */
    public function receivedVisits(): HasMany
    {
        return $this->hasMany(Visit::class, 'agent_id');
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Get formatted phone number
     */
    public function getFormattedPhoneAttribute(): string
    {
        if (!$this->phone) return '';

        // Basic Brazilian phone formatting
        $phone = preg_replace('/\D/', '', $this->phone);

        if (strlen($phone) === 11) {
            return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 5) . '-' . substr($phone, 7);
        } elseif (strlen($phone) === 10) {
            return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 4) . '-' . substr($phone, 6);
        }

        return $this->phone;
    }

    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : asset('images/default-avatar.png');
    }
}
