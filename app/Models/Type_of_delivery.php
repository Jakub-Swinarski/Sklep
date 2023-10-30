<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type_of_delivery extends Model
{
    protected $table = 'type_of_delivery';
    use HasFactory;
    use SoftDeletes;
}
