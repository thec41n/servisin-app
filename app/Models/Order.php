<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'price',
        'name',
        'email',
        'phone_number',
        'item_detail',
        'image',
        'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->tracking_code = 'SVS-'.Str::upper(Str::random(10));
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
