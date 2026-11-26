<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('home_banner_image')->nullable();
            $table->string('home_banner_video_file')->nullable();
            $table->string('home_banner_video_url')->nullable();
            $table->string('home_banner_eyebrow')->nullable();
            $table->string('home_banner_heading')->nullable();
            $table->text('home_banner_subheading')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'home_banner_image',
                'home_banner_video_file',
                'home_banner_video_url',
                'home_banner_eyebrow',
                'home_banner_heading',
                'home_banner_subheading',
            ]);
        });
    }
};
