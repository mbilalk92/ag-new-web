<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageHomeBanner extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Home Banner';

    protected static ?string $navigationGroup = 'Settings';

    protected static string $view = 'filament.pages.manage-home-banner';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->toArray());
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Homepage banner')
                    ->description('The full-width banner at the top of the homepage. Add a video for a cinematic feel (the same treatment used on collection pages, e.g. Virasat), or fall back to a still image. If a video is set, it takes priority over the image.')
                    ->schema([
                        Forms\Components\TextInput::make('home_banner_eyebrow')
                            ->label('Eyebrow text')
                            ->placeholder('Barat · Nikkah · Valima · Mehndi')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('home_banner_heading')
                            ->label('Heading')
                            ->placeholder("Groom's wear, worn once, remembered always.")
                            ->maxLength(255),
                        Forms\Components\Textarea::make('home_banner_subheading')
                            ->label('Supporting text')
                            ->rows(2)
                            ->maxLength(320),
                        Forms\Components\TextInput::make('home_banner_video_url')
                            ->label('Video embed URL (YouTube/Instagram/Vimeo)')
                            ->url()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('home_banner_video_file')
                            ->label('Or upload a video file')
                            ->helperText('Note: recommended 1920×1080px (16:9), landscape, MP4 (H.264), under 15MB. It autoplays muted and loops, so keep it short (5-15 seconds) with no important audio.')
                            ->directory('home-banner')
                            ->acceptedFileTypes(['video/mp4', 'video/quicktime'])
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('home_banner_image')
                            ->label('Or upload a still image')
                            ->helperText('Note: recommended 1920×1080px (16:9), landscape, JPG/WEBP, under 500KB. Used only when no video is set above.')
                            ->image()
                            ->directory('home-banner')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        SiteSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Homepage banner saved')
            ->success()
            ->send();
    }
}
