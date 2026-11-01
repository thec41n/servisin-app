<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Service extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'laptop' => 'Laptop & PC',
        'smartphone' => 'Smartphone & Tablet',
    ];

    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'image',
        'status',
    ];

    protected $appends = ['image_url'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, Order::class);
    }

    protected function shortDescription(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::limit(strip_tags($this->description), 50, '...'),
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
