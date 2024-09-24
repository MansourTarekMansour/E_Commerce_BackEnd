<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = [
        'url',
        'fileable_id',
        'fileable_type',
        'file_type',
    ];

    // Polymorphic relationship
    public function fileable()
    {
        return $this->morphTo();
    }
}
