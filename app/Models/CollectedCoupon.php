<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectedCoupon extends Model
{
    protected $table = 'collected_coupons';
    protected $fillable = ['user_id', 'coupon_id', 'is_used'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
