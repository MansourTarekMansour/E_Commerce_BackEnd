<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone_number', 'password', 'blocked_until'];

   /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'customer_id');
    }

    public function image()
    {
        return $this->morphOne(File::class, 'fileable')->where('file_type', 'image');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'customer_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id');
    }

    /**
     * Store the customer's image.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    public function storeImage($image)
    {
        // Sanitize the file name
        $fileName = time() . '-' . preg_replace('/[^A-Za-z0-9\-_.]/', '', $image->getClientOriginalName());

        // Move the file to the customer_images directory in public
        $image->move(public_path('storage/customer_images'), $fileName);

        // Create or update the file record
        if ($this->image) {
            // Delete the old image file
            Storage::disk('public')->delete('customer_images/' . $this->image->url);
            $this->image()->update(['url' => $fileName]); // Update with new file name
        } else {
            $this->image()->create([
                'url' => $fileName, // Store only the file name
                'fileable_type' => self::class,
                'fileable_id' => $this->id,
                'file_type' => 'image',
            ]);
        }
    }

    /**
     * Get the customer's image URL.
     *
     * @return string|null
     */
    public function getImageUrl()
    {
        return $this->image ? asset('storage/customer_images/' . $this->image->url) : null; // Generate URL using file name
    }

    /**
     * Delete the customer's image.
     *
     * @return void
     */
    public function deleteImage()
    {
        if ($this->image) {
            // Delete the image file from storage
            Storage::disk('public')->delete('customer_images/' . $this->image->url);
            // Delete the image record from the database
            $this->image()->delete();
        }
    }
}