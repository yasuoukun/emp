<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionalBanner extends Model
{
    protected $fillable = ['image_path', 'link_url', 'sort_order', 'is_active'];
}
