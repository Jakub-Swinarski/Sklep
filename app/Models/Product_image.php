<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_image extends Model
{
    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }
    protected $table = 'products_images';
    use HasFactory;
    use SoftDeletes;
}
