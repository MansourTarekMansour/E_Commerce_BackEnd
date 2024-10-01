<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public const IMAGE_DIRECTORY = 'storage/category_images'; // Adjusted to not include 'storage/'

    // Relationship with products
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    /**
     * Store the category image and associate it with the category.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    public function storeImage($image)
    {
        // Sanitize file name
        $fileName = time() . '-' . preg_replace('/[^A-Za-z0-9\-_.]/', '', $image->getClientOriginalName());

        // Move the file to the category_images directory in public
        $image->move(public_path(self::IMAGE_DIRECTORY), $fileName);

        // Store only the file name in the File model
        File::create([
            'url' => $fileName, // Now storing just the file name
            'fileable_id' => $this->id,
            'fileable_type' => self::class,
            'file_type' => 'image',
        ]);
    }

    /**
     * Update the category image, replacing the old one.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    public function updateImage($image)
    {
        // Delete the existing image if it exists
        if ($this->file) {
            $oldFilePath = public_path(self::IMAGE_DIRECTORY . '/' . $this->file->url);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath); // Delete the old file
            }
            $this->file()->delete(); // Delete the file record
        }

        // Store the new image
        $this->storeImage($image);
    }

    /**
     * Delete the category image.
     *
     * @return void
     */
    public function deleteImage()
    {
        if ($this->file) {
            $oldFilePath = public_path(self::IMAGE_DIRECTORY . '/' . $this->file->url);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath); // Delete the old file
            }
            $this->file()->delete(); // Delete the file record
        }
    }

    /**
     * Get the URL of the category image.
     *
     * @return string|null
     */
    public function getImageUrl()
    {
        return $this->file ? asset(self::IMAGE_DIRECTORY . '/' . $this->file->url) : null; // Construct URL based on only the file name
    }
}
