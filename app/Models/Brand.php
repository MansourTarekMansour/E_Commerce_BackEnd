<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    // Method to handle image upload
    public function uploadImage($image)
    {
        // Validate the image type and size if needed before this step
        if ($image) {
            // Sanitize file name
            $fileName = time() . '-' . preg_replace('/[^A-Za-z0-9\-_.]/', '', $image->getClientOriginalName());

            // Move the file to the brand_images directory in public
            $image->move(public_path('storage/brand_images'), $fileName);

            // Create a new file record in the database, storing only the file name
            return $this->file()->create([
                'url' => $fileName, // Storing only the file name
                'file_type' => 'image',
            ]);
        }
        return null;
    }

    // Method to get the image URL
    public function getImageUrl()
    {
        if ($this->file) {
            return asset('storage/brand_images/' . $this->file->url); // Generate the full URL for the image
        }
        return asset('storage/default_image.png'); // Return a default image if none exists
    }

    // Method to delete the associated image file
    public function deleteImage()
    {
        if ($this->file) {
            // Construct the full file path
            $filePath = public_path('storage/brand_images/' . $this->file->url);
            // Delete the file from storage
            if (file_exists($filePath)) {
                unlink($filePath); // Use unlink to delete the file
            }
            // Delete the record from the database
            $this->file()->delete();
        }
    }
}