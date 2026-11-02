<?php

namespace App\Filament\Resources\ClientDiaryPhotoResource\Pages;

use App\Filament\Resources\ClientDiaryPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientDiaryPhotos extends ListRecords
{
    protected static string $resource = ClientDiaryPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
