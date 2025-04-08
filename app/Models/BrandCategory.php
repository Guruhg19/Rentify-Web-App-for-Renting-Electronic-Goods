<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandCategory extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'category_id',
    ];
    public function brand():BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
