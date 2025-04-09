<?php

namespace App\Models;

use App\Casts\MoneyCast;
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
        'total_amount' => MoneyCast::class,
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    // Generate a unique trx_id
    public static function generateUniqueTrxId()
    {
        $prefix = 'RFY';
        do{
            $randomString = $prefix. mt_rand(1000,9999);
        }while (self::where('trx_id', $randomString)->exists());

        return $randomString;
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function store():BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
