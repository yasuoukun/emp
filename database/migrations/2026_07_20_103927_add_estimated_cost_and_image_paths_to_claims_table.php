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
        Schema::table('claims', function (Blueprint $table) {
            if (!Schema::hasColumn('claims', 'estimated_cost')) {
                $table->decimal('estimated_cost', 10, 2)->nullable()->after('admin_notes');
            }
            if (!Schema::hasColumn('claims', 'image_paths')) {
                $table->json('image_paths')->nullable()->after('estimated_cost');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropColumn(['estimated_cost', 'image_paths']);
        });
    }
};
