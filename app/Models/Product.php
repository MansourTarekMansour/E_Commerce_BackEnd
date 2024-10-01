<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'quantity_in_stock',
        'quantity_sold',
        'is_available',
        'rating',
        'user_id',
        'category_id',
        'brand_id',
    ];
  
    public const IMAGE_DIRECTORY = 'storage/product_images';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable'); 
    }

    /**
     * Store multiple images.
     */
    public function storeImages($files)
    {
        foreach ($files as $file) {
            $fileName = $this->storeImage($file);
            File::create([
                'url' => $fileName,
                'fileable_id' => $this->id,
                'fileable_type' => self::class,
                'file_type' => 'image',
            ]);
        }
    }

    /**
     * Store a single image and return its name.
     */
    public static function storeImage($file)
    {
        // Sanitize file name
        $fileName = time() . '-' . preg_replace('/[^A-Za-z0-9\-_.]/', '', $file->getClientOriginalName());

        // Move the file to the product_images directory in public
        $file->move(public_path(self::IMAGE_DIRECTORY), $fileName);

        // Return the stored file name
        return $fileName;
    }

    /**
     * Get the full URL for the stored image.
     */
    public function getImageUrl($fileName)
    {
        return asset(self::IMAGE_DIRECTORY . '/' . $fileName);
    }

    /**
     * Delete the image file from the public directory.
     */
    public static function deleteImage($fileName)
    {
        $filePath = public_path(self::IMAGE_DIRECTORY . '/' . $fileName);
        
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
