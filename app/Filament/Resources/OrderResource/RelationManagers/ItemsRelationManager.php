<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public static function getTitle($ownerRecord, string $pageClass): string
    {
        return 'Order items';
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->label('Item'),
                Tables\Columns\TextColumn::make('item_type')
                    ->label('Type')
                    ->badge(),
                Tables\Columns\TextColumn::make('size')
                    ->label('Size / fit'),
                Tables\Columns\TextColumn::make('measurements')
                    ->label('Measurements')
                    ->state(function ($record) {
                        if (empty($record->measurements)) {
                            return '—';
                        }

                        return collect($record->measurements)
                            ->map(fn ($value, $label) => "{$label}: {$value}\"")
                            ->implode(', ');
                    })
                    ->wrap(),
                Tables\Columns\TextColumn::make('price')
                    ->money('PKR'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('line_total')
                    ->label('Line total')
                    ->state(fn ($record) => $record->price * $record->quantity)
                    ->money('PKR'),
            ]);
    }
}
