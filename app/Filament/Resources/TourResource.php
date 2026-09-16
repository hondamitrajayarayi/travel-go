<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Support\RawJs;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Manajemen Travel';

    protected static ?string $modelLabel = 'Paket Tour';

    protected static ?string $pluralModelLabel = 'Paket Tour';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tour Management')
                    ->tabs([
                        // TAB 1: 01 Package Setup
                        Tabs\Tab::make('01 Package Setup')
                            ->icon('heroicon-o-cube')
                            ->schema([
                                Select::make('country_id')
                                    ->label('Negara Destinasi')
                                    ->relationship('country', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Nama Negara')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required(),
                                        TextInput::make('code')
                                            ->label('Kode Negara (ISO)')
                                            ->placeholder('Misal: JP, ID, CH'),
                                    ])
                                    ->columnSpan(1),

                                Select::make('status')
                                    ->label('Status Ketersediaan')
                                    ->options([
                                        'tersedia' => 'Tersedia',
                                        'penuh'    => 'Penuh',
                                    ])
                                    ->default('tersedia')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('title')
                                    ->label('Judul Paket Tour')
                                    ->placeholder('Misal: Autumn Tokyo & Mount Fuji Deluxe')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                    ->columnSpanFull(),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(Tour::class, 'slug', ignoreRecord: true)
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('destination')
                                    ->label('Destinasi / Rute Kota')
                                    ->placeholder('Misal: Tokyo, Kyoto, Osaka')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                TextInput::make('duration')
                                    ->label('Durasi Paket')
                                    ->placeholder('Misal: 7D6N atau 5H4M')
                                    ->required()
                                    ->columnSpan(1),

                                Select::make('season')
                                    ->label('Musim (Season)')
                                    ->options([
                                        'Musim Semi (Spring)'       => 'Musim Semi (Spring)',
                                        'Musim Panas (Summer)'       => 'Musim Panas (Summer)',
                                        'Musim Gugur (Autumn)'       => 'Musim Gugur (Autumn)',
                                        'Musim Dingin (Winter)'      => 'Musim Dingin (Winter)',
                                        'Sepanjang Tahun (All Season)' => 'Sepanjang Tahun (All Season)',
                                    ])
                                    ->placeholder('Pilih Musim')
                                    ->searchable()
                                    ->nullable()
                                    ->columnSpanFull(),

                                TextInput::make('price')
                                    ->label('Harga Normal (Rp)')
                                    ->prefix('Rp')
                                    ->mask(RawJs::make('$money($input, \',\', \'.\', 0)'))
                                    ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 0, '', '.') : '0')
                                    ->stripCharacters('.')
                                    ->dehydrateStateUsing(fn ($state) => $state ? (float) str_replace('.', '', $state) : 0)
                                    ->placeholder('0')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('promo_price')
                                    ->label('Harga Promo (Rp)')
                                    ->prefix('Rp')
                                    ->mask(RawJs::make('$money($input, \',\', \'.\', 0)'))
                                    ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 0, '', '.') : '0')
                                    ->stripCharacters('.')
                                    ->dehydrateStateUsing(fn ($state) => $state ? (float) str_replace('.', '', $state) : 0)
                                    ->placeholder('Opsional')
                                    ->helperText('Kosongkan jika tidak ada harga diskon/promo')
                                    ->nullable()
                                    ->columnSpan(1),

                                DatePicker::make('start_date')
                                    ->label('Tanggal Mulai Pemberangkatan')
                                    ->displayFormat('d/m/Y')
                                    ->placeholder('Pilih tanggal mulai')
                                    ->nullable()
                                    ->columnSpan(1),

                                DatePicker::make('end_date')
                                    ->label('Tanggal Akhir / Selesai Paket')
                                    ->displayFormat('d/m/Y')
                                    ->placeholder('Pilih tanggal selesai')
                                    ->afterOrEqual('start_date')
                                    ->nullable()
                                    ->columnSpan(1),

                                FileUpload::make('thumbnail')
                                    ->label('Foto Thumbnail Utama')
                                    ->image()
                                    ->directory('tours/thumbnails')
                                    ->columnSpanFull(),

                                RichEditor::make('description')
                                    ->label('Deskripsi Paket')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'bulletList',
                                        'orderedList',
                                        'h2',
                                        'h3',
                                        'link',
                                        'blockquote',
                                        'redo',
                                        'undo',
                                    ])
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        // TAB 2: 02 Guide Setup (Fasilitas & Panduan Tour)
                        Tabs\Tab::make('02 Guide Setup')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                Repeater::make('facilities')
                                    ->label('Daftar Fasilitas & Layanan Tour')
                                    ->relationship('facilities')
                                    ->schema([
                                        Select::make('type')
                                            ->label('Tipe Fasilitas / Layanan')
                                            ->options([
                                                'include' => 'Include (Termasuk)',
                                                'exclude' => 'Exclude (Tidak Termasuk)',
                                            ])
                                            ->required(),

                                        TextInput::make('description')
                                            ->label('Nama/Deskripsi Fasilitas & Layanan Guide')
                                            ->placeholder('Misal: Tour Leader Berbahasa Indonesia, Tiket Masuk Objek Wisata')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(1)
                                    ->addActionLabel('Tambah Fasilitas / Layanan Guide'),
                            ]),

                        // TAB 3: 03 Itinerary (Rencana Perjalanan)
                        Tabs\Tab::make('03 Itinerary')
                            ->icon('heroicon-o-calendar-days')
                            ->schema([
                                Repeater::make('itineraries')
                                    ->label('Rencana Perjalanan Harian')
                                    ->relationship('itineraries')
                                    ->schema([
                                        TextInput::make('day_number')
                                            ->label('Hari Ke-')
                                            ->numeric()
                                            ->required(),

                                        TextInput::make('title')
                                            ->label('Judul Kegiatan')
                                            ->placeholder('Misal: Keberangkatan dari Jakarta ke Tokyo')
                                            ->required(),

                                        RichEditor::make('description')
                                            ->label('Deskripsi Detail Kegiatan')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                                'redo',
                                                'undo',
                                            ])
                                            ->required()
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(1)
                                    ->addActionLabel('Tambah Hari Itinerary'),
                            ]),

                        // TAB 4: 04 Extras & Booking Options (Dokumen Itinerary & Galeri Pendukung)
                        Tabs\Tab::make('04 Extras & Booking Options')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                FileUpload::make('file_itinerary')
                                    ->label('File Itinerary Lengkap (PDF / Dokumen)')
                                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                                    ->directory('tours/itineraries_files')
                                    ->openable()
                                    ->downloadable()
                                    ->helperText('Upload file itinerary lengkap format PDF atau Docx untuk diunduh pengunjung.')
                                    ->columnSpanFull(),

                                Repeater::make('galleries')
                                    ->label('Galeri Foto Tambahan & Dokumentasi')
                                    ->relationship('galleries')
                                    ->schema([
                                        FileUpload::make('image_path')
                                            ->label('Foto Galeri')
                                            ->image()
                                            ->directory('tours/galleries')
                                            ->required(),
                                    ])
                                    ->grid(2)
                                    ->addActionLabel('Tambah Foto Galeri')
                                    ->columnSpanFull(),
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
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('country.name')
                    ->label('Negara')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('season')
                    ->label('Musim')
                    ->badge()
                    ->color('warning')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'tersedia',
                        'danger'  => 'penuh',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'penuh'    => 'Penuh',
                        default    => 'Tersedia',
                    })
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Harga Normal')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                TextColumn::make('promo_price')
                    ->label('Harga Promo')
                    ->money('IDR', locale: 'id')
                    ->placeholder('-')
                    ->color('danger')
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Durasi')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('start_date')
                    ->label('Tgl Mulai')
                    ->date('d M Y')
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('end_date')
                    ->label('Tgl Selesai')
                    ->date('d M Y')
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('file_itinerary')
                    ->label('File Itinerary')
                    ->formatStateUsing(fn ($state) => $state ? 'Tersedia' : 'Tidak Ada')
                    ->badge()
                    ->color(fn ($state) => $state ? 'info' : 'gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('country_id')
                    ->label('Filter Negara')
                    ->relationship('country', 'name'),

                Tables\Filters\SelectFilter::make('season')
                    ->label('Filter Musim')
                    ->options([
                        'Musim Semi (Spring)'       => 'Musim Semi (Spring)',
                        'Musim Panas (Summer)'       => 'Musim Panas (Summer)',
                        'Musim Gugur (Autumn)'       => 'Musim Gugur (Autumn)',
                        'Musim Dingin (Winter)'      => 'Musim Dingin (Winter)',
                        'Sepanjang Tahun (All Season)' => 'Sepanjang Tahun (All Season)',
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'penuh'    => 'Penuh',
                    ]),

                Tables\Filters\Filter::make('departure_period')
                    ->form([
                        DatePicker::make('from')->label('Mulai Dari'),
                        DatePicker::make('until')->label('Sampai Dengan'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('start_date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('end_date', '<=', $date));
                    }),
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
