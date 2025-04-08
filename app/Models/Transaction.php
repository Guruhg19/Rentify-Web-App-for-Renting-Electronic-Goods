<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
        use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'trx_id',
        'phone_number',
        'address',
        'total_amount',
        'is_paid',
        'proof',
        'product_id',
        'store_id',
        'duration',
        'started_at',
        'ended_at',
        'delivery_type'
    ];
    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function store():BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
