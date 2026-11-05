<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSeoSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    protected static ?string $navigationLabel = 'SEO Settings';

    protected static ?string $navigationGroup = 'Settings';

    protected static string $view = 'filament.pages.manage-seo-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->toArray());
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Site defaults')
                    ->description('Used whenever a page doesn\'t set its own title/description — the homepage, shop listing, etc.')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('default_meta_title')
                            ->label('Default meta title')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('default_meta_description')
                            ->label('Default meta description')
                            ->rows(3)
                            ->maxLength(320),
                        Forms\Components\FileUpload::make('default_og_image')
                            ->label('Default social share image (og:image)')
                            ->image()
                            ->directory('seo')
                            ->helperText('Shown when a page is shared on Facebook/WhatsApp/Twitter and has no image of its own. Recommended 1200×630.'),
                    ]),
                Forms\Components\Section::make('Search console & analytics')
                    ->schema([
                        Forms\Components\TextInput::make('google_site_verification')
                            ->label('Google Search Console verification code')
                            ->helperText('Just the content value from the meta tag Google gives you, not the whole tag.'),
                        Forms\Components\TextInput::make('google_analytics_id')
                            ->label('Google Analytics (GA4) Measurement ID')
                            ->placeholder('G-XXXXXXXXXX'),
                        Forms\Components\TextInput::make('meta_pixel_id')
                            ->label('Meta (Facebook) Pixel ID'),
                    ]),
                Forms\Components\Section::make('robots.txt')
                    ->schema([
                        Forms\Components\Textarea::make('robots_extra')
                            ->label('Extra robots.txt rules')
                            ->rows(4)
                            ->helperText('Appended to the generated robots.txt (which already allows crawling and points to the sitemap). Use this for anything extra, e.g. blocking a specific path.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        SiteSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('SEO settings saved')
            ->success()
            ->send();
    }
}
