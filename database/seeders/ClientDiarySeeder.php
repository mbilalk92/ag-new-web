<?php

namespace Database\Seeders;

use App\Models\ClientDiaryPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ClientDiarySeeder extends Seeder
{
    public function run(): void
    {
        $existing = ClientDiaryPhoto::pluck('path')->flip();

        $files = collect(Storage::disk('public')->files('client-diaries'))
            ->filter(fn ($path) => preg_match('/\.(jpg|jpeg|png)$/i', $path))
            ->reject(fn ($path) => $existing->has($path))
            ->sort(SORT_NATURAL)
            ->values();

        $nextSort = (int) ClientDiaryPhoto::max('sort_order') + 1;

        foreach ($files as $index => $path) {
            $fullPath = Storage::disk('public')->path($path);
            [$width, $height] = @getimagesize($fullPath) ?: [1080, 1080];

            ClientDiaryPhoto::create([
                'path' => $path,
                'width' => $width,
                'height' => $height,
                'sort_order' => $nextSort + $index,
                'is_active' => true,
            ]);
        }
    }
}
