<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientDiaryPhotoResource\Pages;
use App\Models\ClientDiaryPhoto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientDiaryPhotoResource extends Resource
{
    protected static ?string $model = ClientDiaryPhoto::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $navigationLabel = 'Client Diaries';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('path')
                    ->label('Photo')
                    ->image()
                    ->directory('client-diaries')
                    ->imageEditor()
                    ->required()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                            [$width, $height] = getimagesize($state->getRealPath());
                            $set('width', $width);
                            $set('height', $height);
                        }
                    }),
                Forms\Components\Hidden::make('width'),
                Forms\Components\Hidden::make('height'),
                Forms\Components\TextInput::make('caption')
                    ->maxLength(255)
                    ->helperText('Optional — shown on hover. Leave blank for a plain photo.'),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Visible on site')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label(''),
                Tables\Columns\TextColumn::make('caption'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientDiaryPhotos::route('/'),
            'create' => Pages\CreateClientDiaryPhoto::route('/create'),
            'edit' => Pages\EditClientDiaryPhoto::route('/{record}/edit'),
        ];
    }
}
