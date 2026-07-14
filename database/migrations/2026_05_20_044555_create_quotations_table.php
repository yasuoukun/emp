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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('quote_no')->unique();
            $table->string('cust_name');
            $table->string('cust_org')->nullable();
            $table->string('cust_tax_id')->nullable();
            $table->string('cust_phone')->nullable();
            $table->string('cust_email')->nullable();
            $table->text('cust_address')->nullable();
            $table->json('items');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('net_total', 12, 2);
            $table->decimal('vat', 12, 2);
            $table->decimal('before_vat', 12, 2);
            $table->string('prepared_by')->nullable();
            $table->text('terms')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected, ordered
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
