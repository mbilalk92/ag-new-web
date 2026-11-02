<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->enum('item_type', ['product', 'bundle'])->default('product')->after('order_id');
            $table->foreignId('bundle_id')->nullable()->after('product_id')->constrained()->nullOnDelete();
            $table->json('measurements')->nullable()->after('size');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('bundle_id');
            $table->dropColumn(['item_type', 'measurements']);
        });
    }
};
