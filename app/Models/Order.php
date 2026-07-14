<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    protected $fillable = ["user_id", "total_amount", "status", "shipping_info", "tracking_number", "shipping_courier", "coupon_code", "discount_amount"];
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    public function confirm()
    {
        if ($this->status !== 'confirmed') {
            $this->update(['status' => 'confirmed']);

            $payment = $this->payments()->first();
            if ($payment) {
                $payment->update(['status' => 'completed']);
            }

            $this->loadMissing('items.product');
            foreach ($this->items as $item) {
                if ($item->product) {
                    $newStock = max(0, $item->product->stock - $item->quantity);
                    $item->product->update(['stock' => $newStock]);
                }
            }
        }
    }

}
