<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (!$category->slug) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get properties for this category
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Get active properties count
     */
    public function getActivePropertiesCountAttribute(): int
    {
        return $this->properties()->where('status', 'ativo')->count();
    }

    /**
     * Get icon URL or default
     */
    public function getIconUrlAttribute(): string
    {
        if ($this->icon) {
            // Se for um emoji (caracter unicode), retornar diretamente
            if (preg_match('/[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{1F1E0}-\x{1F1FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]/u', $this->icon)) {
                return $this->icon;
            }

            // Se for um caminho de arquivo, retornar a URL completa
            return asset('storage/' . $this->icon);
        }

        // Default icons based on category name
        $defaultIcons = [
            'apartamento' => '🏢',
            'casa' => '🏠',
            'terreno' => '🌳',
            'comercial' => '🏬',
            'galpão' => '🏭',
        ];

        $slug = Str::slug($this->name);
        return $defaultIcons[$slug] ?? '🏠';
    }
}
