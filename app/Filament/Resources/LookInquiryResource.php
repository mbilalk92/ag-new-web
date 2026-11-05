<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LookInquiryResource\Pages;
use App\Models\LookInquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LookInquiryResource extends Resource
{
    protected static ?string $model = LookInquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Shop the Look';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Shopper')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')->disabled(),
                        Forms\Components\TextInput::make('email')->disabled(),
                        Forms\Components\TextInput::make('phone')->disabled(),
                        Forms\Components\TextInput::make('city')->disabled(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'New',
                                'contacted' => 'Contacted',
                                'closed' => 'Closed',
                            ])
                            ->required(),
                    ]),
                Forms\Components\Section::make('Sizing')
                    ->schema([
                        Forms\Components\TextInput::make('size')
                            ->disabled()
                            ->visible(fn ($record) => $record?->sizing_mode === 'standard'),
                        Forms\Components\KeyValue::make('measurements')
                            ->disabled()
                            ->visible(fn ($record) => $record?->sizing_mode === 'custom'),
                    ]),
                Forms\Components\Textarea::make('message')
                    ->disabled()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('photo.path')
                    ->label('')
                    ->square(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sizing_mode')
                    ->label('Sizing')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'contacted' => 'info',
                        'closed' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'closed' => 'Closed',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLookInquiries::route('/'),
            'view' => Pages\ViewLookInquiry::route('/{record}'),
            'edit' => Pages\EditLookInquiry::route('/{record}/edit'),
        ];
    }
}
