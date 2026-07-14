<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ["name", "description", "specifications", "freebie", "price", "discount_price", "stock", "category_id", "brand_id", "is_promotion", "is_popular"];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = self::generateUniqueCode();
            }
        });
    }

    private static function generateUniqueCode()
    {
        do {
            $code = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(10));
        } while (self::where('id', $code)->exists());
        return $code;
    }

    public function category() { return $this->belongsTo(Category::class); }
    public function brand() { return $this->belongsTo(Brand::class); }
    public function images() { return $this->hasMany(ProductImage::class); }
    public function reviews() { return $this->hasMany(Review::class); }

}
