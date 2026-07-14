<?php

$dir = __DIR__ . '/database/migrations/';
$files = scandir($dir);

foreach ($files as $file) {
    if (strpos($file, 'create_users_table') !== false) {
        $content = file_get_contents($dir . $file);
        $content = str_replace(
            '$table->string(\'email\')->unique();',
            '$table->string(\'email\')->unique();' . "\n" . '            $table->enum(\'role\', [\'customer\', \'admin\', \'super_admin\'])->default(\'customer\');',
            $content
        );
        file_put_contents($dir . $file, $content);
    }
    
    if (strpos($file, 'create_categories_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '$table->string("name"); $table->text("description")->nullable(); $table->timestamps();', file_get_contents($dir . $file)));
    }
    
    if (strpos($file, 'create_brands_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '$table->string("name"); $table->text("description")->nullable(); $table->timestamps();', file_get_contents($dir . $file)));
    }
    
    if (strpos($file, 'create_products_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '
            $table->string("name");
            $table->text("description")->nullable();
            $table->decimal("price", 10, 2);
            $table->decimal("discount_price", 10, 2)->nullable();
            $table->integer("stock")->default(0);
            $table->foreignId("category_id")->constrained()->onDelete("cascade");
            $table->foreignId("brand_id")->nullable()->constrained()->onDelete("set null");
            $table->boolean("is_promotion")->default(false);
            $table->boolean("is_popular")->default(false);
            $table->timestamps();
        ', file_get_contents($dir . $file)));
    }
    
    if (strpos($file, 'create_product_images_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '
            $table->foreignId("product_id")->constrained()->onDelete("cascade");
            $table->string("image_path");
            $table->boolean("is_primary")->default(false);
            $table->timestamps();
        ', file_get_contents($dir . $file)));
    }
    
    if (strpos($file, 'create_addresses_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->text("address_line");
            $table->string("province");
            $table->string("district");
            $table->string("subdistrict");
            $table->string("postal_code");
            $table->string("phone");
            $table->boolean("is_main")->default(false);
            $table->timestamps();
        ', file_get_contents($dir . $file)));
    }
    
    if (strpos($file, 'create_coupons_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '
            $table->string("code")->unique();
            $table->decimal("discount_amount", 10, 2);
            $table->date("expires_at");
            $table->timestamps();
        ', file_get_contents($dir . $file)));
    }
    
    if (strpos($file, 'create_orders_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->decimal("total_amount", 10, 2);
            $table->enum("status", ["pending", "confirmed", "shipped", "cancelled"])->default("pending");
            $table->text("shipping_info")->nullable();
            $table->timestamps();
        ', file_get_contents($dir . $file)));
    }
    
    if (strpos($file, 'create_order_items_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '
            $table->foreignId("order_id")->constrained()->onDelete("cascade");
            $table->foreignId("product_id")->constrained()->onDelete("cascade");
            $table->integer("quantity");
            $table->decimal("price", 10, 2);
            $table->timestamps();
        ', file_get_contents($dir . $file)));
    }
    
    if (strpos($file, 'create_payments_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '
            $table->foreignId("order_id")->constrained()->onDelete("cascade");
            $table->string("payment_method");
            $table->string("transaction_id")->nullable();
            $table->decimal("amount", 10, 2);
            $table->enum("status", ["pending", "completed", "failed"])->default("pending");
            $table->timestamps();
        ', file_get_contents($dir . $file)));
    }
    
    if (strpos($file, 'create_wishlists_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("product_id")->constrained()->onDelete("cascade");
            $table->timestamps();
        ', file_get_contents($dir . $file)));
    }
    
    if (strpos($file, 'create_messages_table') !== false) {
        file_put_contents($dir . $file, str_replace('$table->timestamps();', '
            $table->foreignId("sender_id")->constrained("users")->onDelete("cascade");
            $table->foreignId("receiver_id")->nullable()->constrained("users")->onDelete("cascade");
            $table->text("content");
            $table->boolean("is_read")->default(false);
            $table->timestamps();
        ', file_get_contents($dir . $file)));
    }
}

echo "Migrations updated successfully.\n";
