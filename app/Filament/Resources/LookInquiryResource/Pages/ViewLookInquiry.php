<?php

namespace App\Filament\Resources\LookInquiryResource\Pages;

use App\Filament\Resources\LookInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLookInquiry extends ViewRecord
{
    protected static string $resource = LookInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
