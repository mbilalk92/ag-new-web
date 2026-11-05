<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BundleResource\Pages;
use App\Models\Bundle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BundleResource extends Resource
{
    protected static ?string $model = Bundle::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Bundle details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('price')
                            ->label('Bundle price (PKR)')
                            ->required()
                            ->numeric()
                            ->prefix('Rs'),
                        Forms\Components\TextInput::make('compare_at_price')
                            ->label('Compare-at price (optional)')
                            ->helperText('Shown struck through, to signal the savings vs buying items separately.')
                            ->numeric()
                            ->prefix('Rs'),
                        Forms\Components\Select::make('measurement_type')
                            ->label('Custom sizing applies to')
                            ->options([
                                'none' => 'No custom sizing',
                                'top' => 'Top garment measurements',
                                'trouser' => 'Trouser measurements',
                                'top_trouser' => 'Top + trouser measurements',
                            ])
                            ->default('top')
                            ->required(),
                        Forms\Components\TagsInput::make('sizes')
                            ->label('Standard sizes')
                            ->placeholder('e.g. S, M, L, XL, XXL'),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3),
                        Forms\Components\Repeater::make('included_items')
                            ->label('What\'s included')
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('Item')
                                    ->required()
                                    ->placeholder('e.g. Sherwani'),
                                Forms\Components\TextInput::make('description')
                                    ->label('Detail')
                                    ->placeholder('e.g. Hand-embroidered, maroon'),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->addActionLabel('Add item'),
                        Forms\Components\TextInput::make('video_url')
                            ->label('Video embed URL (YouTube/Instagram/Vimeo)')
                            ->url()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('video_file')
                            ->label('Or upload a video file')
                            ->directory('bundle-videos')
                            ->acceptedFileTypes(['video/mp4', 'video/quicktime'])
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Feature on homepage'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Visible in store')
                            ->default(true),
                    ]),
                Forms\Components\Section::make('SEO')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(255)
                            ->helperText('Leave blank to use the bundle name.'),
                        Forms\Components\Textarea::make('meta_description')
                            ->rows(2)
                            ->maxLength(320),
                    ]),
                Forms\Components\Section::make('Photos')
                    ->schema([
                        Forms\Components\Repeater::make('images')
                            ->relationship('images')
                            ->schema([
                                Forms\Components\FileUpload::make('path')
                                    ->label('Image')
                                    ->image()
                                    ->directory('bundles')
                                    ->imageEditor()
                                    ->required()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        if ($state instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                            [$width, $height] = getimagesize($state->getRealPath());
                                            $set('width', $width);
                                            $set('height', $height);
                                        }
                                    })
                                    ->columnSpan(2),
                                Forms\Components\Hidden::make('width'),
                                Forms\Components\Hidden::make('height'),
                            ])
                            ->columns(3)
                            ->orderColumn('sort_order')
                            ->defaultItems(1)
                            ->reorderable()
                            ->collapsible()
                            ->addActionLabel('Add photo'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('images.0.path')
                    ->label('')
                    ->square(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('PKR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBundles::route('/'),
            'create' => Pages\CreateBundle::route('/create'),
            'edit' => Pages\EditBundle::route('/{record}/edit'),
        ];
    }
}
