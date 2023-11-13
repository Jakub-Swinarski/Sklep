<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $appends = ['productCount'];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function address(): BelongsTo{
        return $this->BelongsTo(Address::class);
    }
    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class,'orders_products');

    }
    public function typeOfDelivery(): BelongsTo{
        return $this->belongsTo(Type_of_delivery::class);
    }
    protected function getProductCountAttribute(){
        return $this->products()->count();
    }
}
