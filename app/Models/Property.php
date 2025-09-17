<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'title',
        'description',
        'price',
        'currency',
        'address',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'country',
        'latitude',
        'longitude',
        'bedrooms',
        'bathrooms',
        'parking_spaces',
        'area',
        'land_area',
        'floor',
        'total_floors',
        'features',
        'amenities',
        'status',
        'featured',
        'urgent',
        'views',
        'slug',
        'seo_title',
        'seo_description',
        'published_at',
        'expires_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'parking_spaces' => 'integer',
        'area' => 'integer',
        'land_area' => 'integer',
        'floor' => 'integer',
        'total_floors' => 'integer',
        'featured' => 'boolean',
        'urgent' => 'boolean',
        'views' => 'integer',
        'features' => 'array',
        'amenities' => 'array',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Constants
    const TYPE_VENDA = 'venda';
    const TYPE_ALUGUEL = 'aluguel';

    const STATUS_ATIVO = 'ativo';
    const STATUS_INATIVO = 'inativo';
    const STATUS_VENDIDO = 'vendido';
    const STATUS_ALUGADO = 'alugado';

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            if (!$property->slug) {
                $property->slug = Str::slug($property->title . '-' . Str::random(6));
            }

            if (!$property->published_at) {
                $property->published_at = now();
            }
        });

        static::updating(function ($property) {
            if ($property->isDirty('title') && !$property->isDirty('slug')) {
                $property->slug = Str::slug($property->title . '-' . Str::random(6));
            }
        });
    }

    // Scopes
    public function scopeForSale($query)
    {
        return $query->where('type', self::TYPE_VENDA);
    }

    public function scopeForRent($query)
    {
        return $query->where('type', self::TYPE_ALUGUEL);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ATIVO);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeUrgent($query)
    {
        return $query->where('urgent', true);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', 'like', "%{$city}%");
    }

    public function scopeByState($query, $state)
    {
        return $query->where('state', $state);
    }

    public function scopeByPriceRange($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('price', '>=', $min);
        }

        if ($max) {
            $query->where('price', '<=', $max);
        }

        return $query;
    }


    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(PropertyVideo::class)->orderBy('sort_order');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    // Accessors
    public function getFormattedPriceAttribute(): string
    {
        return 'R$ ' . number_format($this->price, 2, ',', '.');
    }

    public function getMainImageAttribute()
    {
        return $this->images()->where('is_featured', true)->first()
            ?? $this->images()->first();
    }

    public function getMainImageUrlAttribute(): string
    {
        $image = $this->main_image;

        if (!$image) {
            return asset('images/default-property.jpg');
        }

        // Se for imagem externa (usada no seeder), retornar diretamente
        if ($image->disk === 'external') {
            return $image->path;
        }

        return asset('storage/' . $image->path);
    }

    public function getThumbnailUrlAttribute(): string
    {
        $image = $this->main_image;

        if (!$image) {
            return asset('images/default-property.jpg');
        }

        // Se for imagem externa (usada no seeder), retornar diretamente
        if ($image->disk === 'external') {
            return $image->path;
        }

        if ($image->thumbnail_path) {
            return asset('storage/' . $image->thumbnail_path);
        }

        return $this->main_image_url;
    }

    public function getFullAddressAttribute(): string
    {
        return $this->address . ', ' . $this->neighborhood . ', ' . $this->city . ' - ' . $this->state;
    }

    public function getAreaFormattedAttribute(): string
    {
        return $this->area ? $this->area . ' m²' : '';
    }

    public function getLandAreaFormattedAttribute(): string
    {
        return $this->land_area ? $this->land_area . ' m²' : '';
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === self::TYPE_VENDA ? 'Venda' : 'Aluguel';
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ATIVO => 'Ativo',
            self::STATUS_INATIVO => 'Inativo',
            self::STATUS_VENDIDO => 'Vendido',
            self::STATUS_ALUGADO => 'Alugado',
            default => 'Desconhecido',
        };
    }

    public function getIsAvailableAttribute(): bool
    {
        return in_array($this->status, [self::STATUS_ATIVO]);
    }

    public function getTotalMediaCountAttribute(): int
    {
        return $this->images()->count() + $this->videos()->count();
    }

    // Methods
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function toggleFavorite(User $user): bool
    {
        $favorite = $this->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();
            return false; // Removed from favorites
        } else {
            $this->favorites()->create(['user_id' => $user->id]);
            return true; // Added to favorites
        }
    }

    public function isFavoritedBy(User $user): bool
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function getFeaturesListAttribute(): array
    {
        return $this->features ?? [];
    }

    public function getAmenitiesListAttribute(): array
    {
        return $this->amenities ?? [];
    }
}
