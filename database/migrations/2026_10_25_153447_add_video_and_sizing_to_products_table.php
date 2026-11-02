<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('video_file')->nullable()->after('stock');
            $table->string('video_url')->nullable()->after('video_file');
            $table->boolean('allow_custom_sizing')->default(false)->after('video_url');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['video_file', 'video_url', 'allow_custom_sizing']);
        });
    }
};
