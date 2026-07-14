<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            
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
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
