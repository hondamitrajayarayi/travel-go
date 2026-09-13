<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Manajemen Travel';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tour Details')
                    ->tabs([
                        // TAB 1: Detail Utama Tour
                        Tabs\Tab::make('Informasi Utama')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Paket')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(Tour::class, 'slug', ignoreRecord: true)
                                    ->maxLength(255),

                                TextInput::make('destination')
                                    ->label('Destinasi')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('price')
                                    ->label('Harga Paket (Rp)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),

                                TextInput::make('duration')
                                    ->label('Durasi Paket')
                                    ->required()
                                    ->placeholder('Misal: 3H2M'),

                                FileUpload::make('thumbnail')
                                    ->label('Foto Thumbnail')
                                    ->image()
                                    ->directory('tours/thumbnails')
                                    ->columnSpanFull(),

                                Textarea::make('description')
                                    ->label('Deskripsi Paket')
                                    ->rows(5)
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        // TAB 2: Itinerary (Repeater HasMany)
                        Tabs\Tab::make('Rencana Perjalanan (Itinerary)')
                            ->schema([
                                Repeater::make('itineraries')
                                    ->relationship('itineraries')
                                    ->schema([
                                        TextInput::make('day_number')
                                            ->label('Hari Ke-')
                                            ->numeric()
                                            ->required(),

                                        TextInput::make('title')
                                            ->label('Judul Kegiatan')
                                            ->required(),

                                        Textarea::make('description')
                                            ->label('Deskripsi Kegiatan')
                                            ->rows(3)
                                            ->required()
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(1)
                                    ->addActionLabel('Tambah Hari Itinerary'),
                            ]),

                        // TAB 3: Fasilitas (Repeater HasMany)
                        Tabs\Tab::make('Fasilitas')
                            ->schema([
                                Repeater::make('facilities')
                                    ->relationship('facilities')
                                    ->schema([
                                        Select::make('type')
                                            ->label('Tipe Fasilitas')
                                            ->options([
                                                'include' => 'Include (Termasuk)',
                                                'exclude' => 'Exclude (Tidak Termasuk)',
                                            ])
                                            ->required(),

                                        TextInput::make('description')
                                            ->label('Nama/Deskripsi Fasilitas')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(1)
                                    ->addActionLabel('Tambah Fasilitas'),
                            ]),

                        // TAB 4: Galeri Foto (Repeater HasMany)
                        Tabs\Tab::make('Galeri Foto')
                            ->schema([
                                Repeater::make('galleries')
                                    ->relationship('galleries')
                                    ->schema([
                                        FileUpload::make('image_path')
                                            ->label('Foto Galeri')
                                            ->image()
                                            ->directory('tours/galleries')
                                            ->required(),
                                    ])
                                    ->grid(2)
                                    ->addActionLabel('Tambah Foto Galeri'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->square(),

                TextColumn::make('title')
                    ->label('Judul Paket')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('destination')
                    ->label('Destinasi')
                    ->searchable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Durasi')
                    ->badge(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index'  => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit'   => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}
