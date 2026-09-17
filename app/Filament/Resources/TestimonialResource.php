<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Manajemen Travel';

    protected static ?string $navigationLabel = 'Testimoni Cerita';

    protected static ?string $modelLabel = 'Testimoni Cerita';

    protected static ?string $pluralModelLabel = 'Testimoni Cerita Wisatawan';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Traveler & Trip')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Traveler / Keluarga')
                            ->placeholder('Contoh: Bapak Hendra & Keluarga, dr. Kevin Pratama')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('tour_title')
                            ->label('Paket Tour / Destinasi')
                            ->placeholder('Contoh: Favorite Autumn in China 2026, Japan Golden Route')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('trip_date')
                            ->label('Waktu / Periode Trip')
                            ->placeholder('Contoh: Oktober 2026, Musim Gugur 2026')
                            ->maxLength(255),

                        Select::make('rating')
                            ->label('Rating Bintang')
                            ->options([
                                5 => '⭐⭐⭐⭐⭐ (5 Bintang - Sangat Memuaskan)',
                                4 => '⭐⭐⭐⭐ (4 Bintang - Memuaskan)',
                                3 => '⭐⭐⭐ (3 Bintang - Cukup)',
                                2 => '⭐⭐ (2 Bintang)',
                                1 => '⭐ (1 Bintang)',
                            ])
                            ->default(5)
                            ->required(),

                        Textarea::make('story')
                            ->label('Cerita & Pengalaman Setelah Pulang')
                            ->placeholder('Tuliskan cerita pengalaman berkesan traveler selama perjalanan...')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Foto & Pengaturan Tampilan')
                    ->schema([
                        FileUpload::make('avatar')
                            ->label('Foto Profil Traveler (Avatar)')
                            ->image()
                            ->directory('testimonials/avatars')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300'),

                        FileUpload::make('photo')
                            ->label('Foto Dokumentasi / Kenangan Trip (Opsional)')
                            ->image()
                            ->directory('testimonials/photos'),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('Tampilkan di Website')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order', 'asc')
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?background=1B5A7A&color=fff&name=Traveler'),

                TextColumn::make('name')
                    ->label('Nama Traveler')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('tour_title')
                    ->label('Paket Tour')
                    ->searchable()
                    ->sortable()
                    ->limit(25),

                TextColumn::make('trip_date')
                    ->label('Waktu Trip')
                    ->badge()
                    ->color('info'),

                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', (int) $state)),

                TextColumn::make('story')
                    ->label('Cerita Testimoni')
                    ->limit(45)
                    ->tooltip(fn ($record) => $record->story),

                ToggleColumn::make('is_active')
                    ->label('Status Aktif'),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
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
            'index'  => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit'   => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
