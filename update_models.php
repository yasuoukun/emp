<?php

$dir = __DIR__ . '/app/Models/';

function appendToModel($file, $content) {
    global $dir;
    $filePath = $dir . $file;
    $modelContent = file_get_contents($filePath);
    $modelContent = str_replace('}', $content . "\n}", $modelContent);
    file_put_contents($filePath, $modelContent);
}

appendToModel('User.php', '
    public function addresses() { return $this->hasMany(Address::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function wishlists() { return $this->hasMany(Wishlist::class); }
    public function sentMessages() { return $this->hasMany(Message::class, "sender_id"); }
    public function receivedMessages() { return $this->hasMany(Message::class, "receiver_id"); }
');

appendToModel('Category.php', '
    protected $fillable = ["name", "description"];
    public function products() { return $this->hasMany(Product::class); }
');

appendToModel('Brand.php', '
    protected $fillable = ["name", "description"];
    public function products() { return $this->hasMany(Product::class); }
');

appendToModel('Product.php', '
    protected $fillable = ["name", "description", "price", "discount_price", "stock", "category_id", "brand_id", "is_promotion", "is_popular"];
    public function category() { return $this->belongsTo(Category::class); }
    public function brand() { return $this->belongsTo(Brand::class); }
    public function images() { return $this->hasMany(ProductImage::class); }
');

appendToModel('ProductImage.php', '
    protected $fillable = ["product_id", "image_path", "is_primary"];
    public function product() { return $this->belongsTo(Product::class); }
');

appendToModel('Address.php', '
    protected $fillable = ["user_id", "address_line", "province", "district", "subdistrict", "postal_code", "phone", "is_main"];
    public function user() { return $this->belongsTo(User::class); }
');

appendToModel('Coupon.php', '
    protected $fillable = ["code", "discount_amount", "expires_at"];
');

appendToModel('Order.php', '
    protected $fillable = ["user_id", "total_amount", "status", "shipping_info"];
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function payments() { return $this->hasMany(Payment::class); }
');

appendToModel('OrderItem.php', '
    protected $fillable = ["order_id", "product_id", "quantity", "price"];
    public function order() { return $this->belongsTo(Order::class); }
    public function product() { return $this->belongsTo(Product::class); }
');

appendToModel('Payment.php', '
    protected $fillable = ["order_id", "payment_method", "transaction_id", "amount", "status"];
    public function order() { return $this->belongsTo(Order::class); }
');

appendToModel('Wishlist.php', '
    protected $fillable = ["user_id", "product_id"];
    public function user() { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class); }
');

appendToModel('Message.php', '
    protected $fillable = ["sender_id", "receiver_id", "content", "is_read"];
    public function sender() { return $this->belongsTo(User::class, "sender_id"); }
    public function receiver() { return $this->belongsTo(User::class, "receiver_id"); }
');

echo "Models updated successfully.\n";
