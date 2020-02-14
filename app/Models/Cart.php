<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{   
    use SoftDeletes;
    protected $fillable = ['vendor_id','price','user_id','product_id','qty','session_id'];


    public function product()
    {
      return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
