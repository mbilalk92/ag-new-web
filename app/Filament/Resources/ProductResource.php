<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('occasions')
                            ->relationship('occasions', 'name')
                            ->multiple()
                            ->preload(),
                        Forms\Components\Select::make('collections')
                            ->relationship('collections', 'name')
                            ->multiple()
                            ->preload(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('stock')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('price')
                            ->label('Price (PKR)')
                            ->required()
                            ->numeric()
                            ->prefix('Rs'),
                        Forms\Components\TextInput::make('sale_price')
                            ->label('Sale price (PKR, optional)')
                            ->numeric()
                            ->prefix('Rs'),
                        Forms\Components\TagsInput::make('sizes')
                            ->label('Standard sizes')
                            ->placeholder('e.g. S, M, L, XL, XXL, XXXL (or shoe sizes: 40, 41, 42...)')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('allow_custom_sizing')
                            ->label('Allow custom measurements')
                            ->helperText('Shows a "Customize" option on the product page using the measurement fields set on this product\'s category.')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('video_url')
                            ->label('Video embed URL (YouTube/Instagram/Vimeo)')
                            ->url()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('video_file')
                            ->label('Or upload a video file')
                            ->directory('product-videos')
                            ->acceptedFileTypes(['video/mp4', 'video/quicktime'])
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(4),
                        Forms\Components\Textarea::make('fabric_details')
                            ->label('Fabric & craft details')
                            ->columnSpanFull()
                            ->rows(3),
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
                            ->label('Meta title')
                            ->maxLength(255)
                            ->helperText('Leave blank to use the product name.'),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta description')
                            ->rows(2)
                            ->maxLength(320)
                            ->helperText('Leave blank to use the product description.'),
                    ]),
                Forms\Components\Section::make('Photos')
                    ->description('Upload the product photos that appear in the Pinterest-style feed and gallery. Order matters.')
                    ->schema([
                        Forms\Components\Repeater::make('images')
                            ->relationship('images')
                            ->schema([
                                Forms\Components\FileUpload::make('path')
                                    ->label('Image')
                                    ->image()
                                    ->directory('products')
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
            ->columns([
                Tables\Columns\ImageColumn::make('images.0.path')
                    ->label('')
                    ->square(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('PKR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_video')
                    ->label('Video')
                    ->boolean()
                    ->state(fn ($record) => (bool) ($record->video_file || $record->video_url)),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_featured'),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
