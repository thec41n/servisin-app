<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'rating',
        'comment',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    protected function reviewerName(): Attribute
    {
        return Attribute::get(function () {
            $names = preg_split('/\s+/', trim($this->order->name));

            return $names[0].(isset($names[1]) ? ' '.mb_substr($names[1], 0, 1).'.' : '');
        });
    }
}
