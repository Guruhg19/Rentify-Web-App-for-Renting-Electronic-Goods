<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
        use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'logo',
    ];

    public function products():HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function brandCategories():HasMany
    {
        return $this->hasMany(BrandCategory::class, 'brand_id');
    }
}
