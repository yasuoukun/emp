<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //

    protected $fillable = ["user_id", "address_line", "province", "district", "subdistrict", "postal_code", "phone", "is_main"];
    public function user() { return $this->belongsTo(User::class); }

}
