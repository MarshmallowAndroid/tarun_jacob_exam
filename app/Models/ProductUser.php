<?php

namespace App\Models;

use App\DeliveryStatus;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductUser extends Pivot
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'status',
    ];

    protected function casts()
    {
        return [
            'status' => DeliveryStatus::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
