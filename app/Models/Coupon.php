<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //

    protected $fillable = ["code", "name", "product_id", "discount_amount", "expires_at"];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
