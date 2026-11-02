<?php

namespace Database\Seeders;

use App\Models\ClientDiaryPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ClientDiarySeeder extends Seeder
{
    public function run(): void
    {
        $files = collect(Storage::disk('public')->files('client-diaries'))
            ->filter(fn ($path) => preg_match('/diary-\d+\.(jpg|jpeg|png)$/i', $path))
            ->sort()
            ->values();

        foreach ($files as $index => $path) {
            $fullPath = Storage::disk('public')->path($path);
            [$width, $height] = @getimagesize($fullPath) ?: [900, 1100];

            ClientDiaryPhoto::create([
                'path' => $path,
                'width' => $width,
                'height' => $height,
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }
    }
}
