<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_name',
        'email',
        'phone_number',
        'address',
        'logo',
        'social_links',
    ];

    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->logo && Storage::disk('public')->exists($this->logo)) {
                    return asset('storage/' . $this->logo);
                }

                return null;
            },
        );
    }
}
