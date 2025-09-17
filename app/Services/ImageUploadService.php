<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyVideo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Upload property images with optimization
     */
    public function uploadPropertyImages(Property $property, array $files): void
    {
        $sortOrder = $property->images()->max('sort_order') ?? 0;

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $this->processPropertyImage($property, $file, ++$sortOrder);
            }
        }
    }

    /**
     * Process and upload a single property image
     */
    private function processPropertyImage(Property $property, UploadedFile $file, int $sortOrder): PropertyImage
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "properties/{$property->id}/images/{$filename}";

        // Store original image
        $storedPath = $file->storeAs("properties/{$property->id}/images", $filename, 'public');

        // Get image dimensions
        $imageInfo = getimagesize($file->getPathname());
        $dimensions = [
            'width' => $imageInfo[0] ?? null,
            'height' => $imageInfo[1] ?? null,
        ];

        // Create thumbnail if image is large
                $thumbnailPath = null;
                // Thumbnail creation disabled - requires Intervention Image package
                // if ($dimensions['width'] > 800 || $dimensions['height'] > 600) {
                //     $thumbnailPath = $this->createThumbnail($file, $property->id, $filename);
                // }

        return PropertyImage::create([
            'property_id' => $property->id,
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'path' => $storedPath,
            'disk' => 'public',
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'dimensions' => $dimensions,
            'sort_order' => $sortOrder,
            'is_featured' => $sortOrder === 1, // First image is featured by default
        ]);
    }

    /**
     * Create thumbnail for image
     */
    private function createThumbnail(UploadedFile $file, int $propertyId, string $filename): ?string
    {
        // Temporarily disabled - requires Intervention Image package
        // TODO: Install Intervention Image for thumbnail generation
        \Log::info('Thumbnail creation skipped - Intervention Image not installed');
        return null;

        /*
        try {
            $thumbnailFilename = 'thumb_' . $filename;
            $thumbnailPath = "properties/{$propertyId}/thumbnails/{$thumbnailFilename}";

            $image = Image::make($file)->fit(400, 300, function ($constraint) {
                $constraint->upsize();
            });

            Storage::disk('public')->put($thumbnailPath, $image->encode());

            return $thumbnailPath;
        } catch (\Exception $e) {
            // Log error but don't fail the upload
            \Log::warning('Failed to create thumbnail: ' . $e->getMessage());
            return null;
        }
        */
    }

    /**
     * Upload property videos
     */
    public function uploadPropertyVideos(Property $property, array $files): void
    {
        $sortOrder = $property->videos()->max('sort_order') ?? 0;

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $this->processPropertyVideo($property, $file, ++$sortOrder);
            }
        }
    }

    /**
     * Process and upload a single property video
     */
    private function processPropertyVideo(Property $property, UploadedFile $file, int $sortOrder): PropertyVideo
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "properties/{$property->id}/videos/{$filename}";

        // Store video file
        $storedPath = $file->storeAs("properties/{$property->id}/videos", $filename, 'public');

        // Get basic video info (duration will be extracted later by a job)
        $duration = $this->extractVideoDuration($file);

        return PropertyVideo::create([
            'property_id' => $property->id,
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'path' => $storedPath,
            'disk' => 'public',
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'duration' => $duration,
            'sort_order' => $sortOrder,
            'is_featured' => $sortOrder === 1,
            'processing_status' => $duration ? 'completed' : 'pending',
        ]);
    }

    /**
     * Extract video duration (simplified version)
     */
    private function extractVideoDuration(UploadedFile $file): ?int
    {
        // This is a simplified version. In production, you'd use FFmpeg or similar
        // For now, return null and let a background job handle it
        return null;
    }

    /**
     * Delete image and its files
     */
    public function deletePropertyImage(PropertyImage $image): void
    {
        Storage::disk($image->disk)->delete($image->path);

        // Delete thumbnail if exists
        if ($image->thumbnail_path) {
            Storage::disk($image->disk)->delete($image->thumbnail_path);
        }

        $image->delete();
    }

    /**
     * Delete video and its files
     */
    public function deletePropertyVideo(PropertyVideo $video): void
    {
        Storage::disk($video->disk)->delete($video->path);

        // Delete thumbnail if exists
        if ($video->thumbnail_path) {
            Storage::disk($video->disk)->delete($video->thumbnail_path);
        }

        $video->delete();
    }

    /**
     * Reorder property images
     */
    public function reorderPropertyImages(Property $property, array $imageOrder): void
    {
        foreach ($imageOrder as $order => $imageId) {
            PropertyImage::where('id', $imageId)
                ->where('property_id', $property->id)
                ->update(['sort_order' => $order + 1]);
        }
    }
}
