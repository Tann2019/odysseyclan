<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Upload and process an image file
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param array $options
     * @return string|null
     */
    public function uploadImage(UploadedFile $file, string $directory, array $options = []): ?string
    {
        // Validate file type
        if (!$this->isValidImageType($file)) {
            return null;
        }

        // Validate file size (max 5MB)
        if ($file->getSize() > 5 * 1024 * 1024) {
            return null;
        }

        // Generate unique filename
        $filename = $this->generateFilename($file);
        $path = $directory . '/' . $filename;

        try {
            // Store file
            $file->storeAs($directory, $filename, 'public');
            return '/storage/' . $path;
        } catch (\Exception $e) {
            \Log::error('Image upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete an image file
     *
     * @param string|null $imagePath
     * @return bool
     */
    public function deleteImage(?string $imagePath): bool
    {
        if (!$imagePath) {
            return true;
        }

        // Extract path from storage URL
        $path = str_replace('/storage/', '', $imagePath);
        
        try {
            return Storage::disk('public')->delete($path);
        } catch (\Exception $e) {
            \Log::error('Image deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Upload avatar
     *
     * @param UploadedFile $file
     * @return string|null
     */
    public function uploadAvatar(UploadedFile $file): ?string
    {
        return $this->uploadImage($file, 'avatars');
    }

    /**
     * Upload news image
     *
     * @param UploadedFile $file
     * @return string|null
     */
    public function uploadNewsImage(UploadedFile $file): ?string
    {
        return $this->uploadImage($file, 'news');
    }

    /**
     * Upload gallery image
     *
     * @param UploadedFile $file
     * @return string|null
     */
    public function uploadGalleryImage(UploadedFile $file): ?string
    {
        return $this->uploadImage($file, 'gallery');
    }

    /**
     * Check if file is a valid image type
     *
     * @param UploadedFile $file
     * @return bool
     */
    private function isValidImageType(UploadedFile $file): bool
    {
        $allowedTypes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
        return in_array(strtolower($file->getClientOriginalExtension()), $allowedTypes);
    }

    /**
     * Generate unique filename
     *
     * @param UploadedFile $file
     * @return string
     */
    private function generateFilename(UploadedFile $file): string
    {
        return time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Get file size in human readable format
     *
     * @param UploadedFile $file
     * @return string
     */
    public function getFileSize(UploadedFile $file): string
    {
        $bytes = $file->getSize();
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}