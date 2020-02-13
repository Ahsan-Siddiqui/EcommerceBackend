<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['vendor_id','user_id','product_id','qty','session_id'];
}
