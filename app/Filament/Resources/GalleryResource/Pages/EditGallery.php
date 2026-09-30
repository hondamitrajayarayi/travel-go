<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use App\Models\Country;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditGallery extends EditRecord
{
    protected static string $resource = GalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Override form for editing: show single-record fields (no Repeater).
     */
    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Negara Destinasi')
                ->icon('heroicon-o-globe-alt')
                ->schema([
                    Select::make('category')
                        ->label('Negara')
                        ->options(fn () => Country::query()->orderBy('name')->pluck('name', 'name')->toArray())
                        ->searchable()
                        ->preload()
                        ->required()
                        ->columnSpanFull(),
                ]),

            Section::make('Informasi Dokumentasi')
                ->icon('heroicon-o-document-text')
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Dokumentasi')
                        ->placeholder('Contoh: Momen Sunset di Santorini, Autumn di Kyoto')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('destination')
                        ->label('Destinasi / Kota')
                        ->placeholder('Contoh: Tokyo & Kyoto, Cappadocia, Zurich')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),

            Section::make('Foto & Pengaturan')
                ->icon('heroicon-o-photo')
                ->schema([
                    FileUpload::make('images')
                        ->label('Foto Dokumentasi')
                        ->helperText('Bisa memilih beberapa foto sekaligus.')
                        ->multiple()
                        ->reorderable()
                        ->image()
                        ->directory('galleries')
                        ->imageResizeMode('cover')
                        ->maxFiles(30)
                        ->columnSpanFull(),

                    Toggle::make('is_featured')
                        ->label('Highlight')
                        ->helperText('Tandai sebagai dokumentasi pilihan utama dan ditampilkan dihalaman awal')
                        ->default(false),

                    Toggle::make('is_active')
                        ->label('Aktif (Tampilkan di Website)')
                        ->default(true),
                ])
                ->columns(2),
        ]);
    }
}
