<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'user_id',
        'quote_no',
        'cust_name',
        'cust_org',
        'cust_tax_id',
        'cust_phone',
        'cust_email',
        'cust_address',
        'items',
        'subtotal',
        'discount',
        'net_total',
        'vat',
        'before_vat',
        'prepared_by',
        'terms',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
