<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $appends = ['avgRating','countRatings','image'];

    public function first_image(): HasOne{
        return $this->hasOne(Product_image::class)->oldestOfMany();
    }
    public function images(): HasMany{
        return $this->hasMany(Product_image::class);
    }
    public function ratings(): HasMany{
        return $this->hasMany(Rating::class);
    }
    public function categories(): BelongsToMany{
        return $this->belongsToMany(Products_category::class,'products_products_categories','product_id','category_id')
            ->whereNull('products_products_categories.deleted_at');
    }


    protected function getAvgRatingAttribute()
    {
        return $this->ratings()->avg('rating');
    }
    protected function getCountRatingsAttribute()
    {
        return $this->ratings()->count();
    }

    protected function getimageAttribute(){
        return $this->first_image()->get();
    }

    use HasFactory;
    use SoftDeletes;
}
