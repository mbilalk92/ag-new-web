<?php

namespace App\Filament\Resources\LookInquiryResource\Pages;

use App\Filament\Resources\LookInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLookInquiry extends EditRecord
{
    protected static string $resource = LookInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
