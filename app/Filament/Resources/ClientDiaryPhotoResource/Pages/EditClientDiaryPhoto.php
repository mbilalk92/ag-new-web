<?php

namespace App\Filament\Resources\ClientDiaryPhotoResource\Pages;

use App\Filament\Resources\ClientDiaryPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientDiaryPhoto extends EditRecord
{
    protected static string $resource = ClientDiaryPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
