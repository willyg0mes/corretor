<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PropertyVideo extends Model
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
        'duration',
        'dimensions',
        'thumbnail_path',
        'alt_text',
        'caption',
        'sort_order',
        'is_featured',
        'processing_status',
    ];

    protected $casts = [
        'dimensions' => 'array',
        'size' => 'integer',
        'duration' => 'integer',
        'sort_order' => 'integer',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the property that owns the video
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the full URL for the video
     */
    public function getUrlAttribute(): string
    {
        // Usar rota personalizada para contornar proxy Squid
        $videoPath = str_replace('properties/', '', $this->path);
        return route('serve.video', ['video' => $videoPath]);
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail_path) {
            try {
                // Usar disco padrão se o disco especificado não existir
                $disk = $this->disk && Storage::disk($this->disk) ? $this->disk : 'public';
                return Storage::disk($disk)->url($this->thumbnail_path);
            } catch (\Exception $e) {
                // Fallback para asset se houver erro
                return asset('images/default-video-thumbnail.svg');
            }
        }

        return asset('images/default-video-thumbnail.svg');
    }

    /**
     * Get duration in human readable format
     */
    public function getDurationFormattedAttribute(): string
    {
        if (!$this->duration) return '';

        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Check if video is processed
     */
    public function isProcessed(): bool
    {
        return $this->processing_status === 'completed';
    }

    /**
     * Delete files when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($video) {
            try {
                // Usar disco padrão se o disco especificado não existir
                $disk = $video->disk && Storage::disk($video->disk) ? $video->disk : 'public';
                Storage::disk($disk)->delete($video->path);
                if ($video->thumbnail_path) {
                    Storage::disk($disk)->delete($video->thumbnail_path);
                }
            } catch (\Exception $e) {
                // Log do erro mas não interrompe a exclusão do modelo
                \Log::error('Erro ao deletar arquivos do vídeo: ' . $e->getMessage());
            }
        });
    }
}
