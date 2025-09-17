<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'filename',
        'original_filename',
        'path',
        'disk',
        'mime_type',
        'size',
        'dimensions',
        'alt_text',
        'caption',
        'sort_order',
        'is_featured',
    ];

    protected $casts = [
        'dimensions' => 'array',
        'size' => 'integer',
        'sort_order' => 'integer',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the property that owns the image
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the full URL for the image
     */
    public function getUrlAttribute(): string
    {
        // Se for imagem externa (usada no seeder), retornar diretamente
        if ($this->disk === 'external') {
            return $this->path;
        }

        // Para imagens locais, usar asset() que respeita a configuração APP_URL
        return asset('storage/' . $this->path);
    }

    /**
     * Get the thumbnail URL (if exists, otherwise return main image)
     */
    public function getThumbnailUrlAttribute(): string
    {
        // For now, return the main image. In a real implementation,
        // you'd have a thumbnail_path field or generate thumbnails
        return $this->url;
    }

    /**
     * Get image dimensions as width x height
     */
    public function getDimensionsFormattedAttribute(): string
    {
        if (!$this->dimensions) return '';

        return $this->dimensions['width'] . 'x' . $this->dimensions['height'];
    }

    /**
     * Get file size in human readable format
     */
    public function getSizeFormattedAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Delete the image file when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            try {
                // Não deletar imagens externas (do seeder)
                if ($image->disk === 'external') {
                    return;
                }

                // Usar disco padrão se o disco especificado não existir
                $disk = $image->disk && Storage::disk($image->disk) ? $image->disk : 'public';
                Storage::disk($disk)->delete($image->path);
            } catch (\Exception $e) {
                // Log do erro mas não interrompe a exclusão do modelo
                \Log::error('Erro ao deletar arquivo da imagem: ' . $e->getMessage());
            }
        });
    }
}
