<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'status',
    ];

    protected $appends = ['image_url'];

    protected function shortDescription(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::limit($this->description, 50, '...'),
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
                    return asset('storage/' . $this->image);
                }
                return null;
            },
        );
    }
}
