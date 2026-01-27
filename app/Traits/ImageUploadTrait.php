<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    /**
     * Upload a new image and optionally delete the old one.
     *
     * @param UploadedFile $file The file to upload.
     * @param string $folder The folder to store the image in.
     * @param string|null $oldPath The path of the old image to delete.
     * @param string $disk The storage disk to use (default: public).
     * @return string The path of the stored image.
     */
    public function updateImage(UploadedFile $file, string $folder, ?string $oldPath = null, string $disk = 'public'): string
    {
        // Delete old image if it exists
        if ($oldPath) {
            $this->deleteImage($oldPath, $disk);
        }

        // Upload new image
        return $file->store($folder, $disk);
    }

    /**
     * Upload a generic file (alias for store, but good for consistency).
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string $disk
     * @return string
     */
    public function uploadImage(UploadedFile $file, string $folder, string $disk = 'public'): string
    {
        return $file->store($folder, $disk);
    }

    /**
     * Delete an image from storage.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    public function deleteImage(?string $path, string $disk = 'public'): bool
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        return false;
    }
}
