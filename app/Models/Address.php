<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    protected $table = 'address';
    use HasFactory;
    use SoftDeletes;
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function orders(): BelongsTo{
        return $this->BelongsTo(Order::class);
    }
}
