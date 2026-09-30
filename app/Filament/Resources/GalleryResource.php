<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Country;
use App\Models\Gallery;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Manajemen Travel';

    protected static ?string $navigationLabel = 'Galeri & Dokumentasi';

    protected static ?string $modelLabel = 'Galeri Trip';

    protected static ?string $pluralModelLabel = 'Galeri & Dokumentasi Trip';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // ── Langkah 1: Pilih Negara ──────────────────────────────────
                Section::make('Negara Destinasi')
                    ->description('Pilih negara destinasi terlebih dahulu, lalu tambahkan satu atau lebih dokumentasi di bawah.')
                    ->icon('heroicon-o-globe-alt')
                    ->schema([
                        Select::make('category')
                            ->label('Negara')
                            ->placeholder('Pilih negara destinasi...')
                            ->options(fn () => Country::query()->orderBy('name')->pluck('name', 'name')->toArray())
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (?string $state, $set) {
                                if (blank($state)) {
                                    $set('_country_has_data', false);
                                    return;
                                }
                                $count = Gallery::where('category', $state)->count();
                                $set('_country_has_data', $count > 0);
                                if ($count > 0) {
                                    Notification::make()
                                        ->warning()
                                        ->title('Negara ini sudah memiliki dokumentasi')
                                        ->body("Terdapat {$count} dokumentasi untuk negara \"{$state}\". Silahkan edit dokumentasi yang sudah ada daripada membuat baru.")
                                        ->persistent()
                                        ->send();
                                }
                            })
                            ->columnSpanFull(),

                        Placeholder::make('_country_warning')
                            ->label('')
                            ->content(function (Get $get): HtmlString|string {
                                $category = $get('category');
                                $hasData  = $get('_country_has_data');

                                if (! $hasData || blank($category)) {
                                    return '';
                                }

                                $galleries = Gallery::where('category', $category)
                                    ->orderByDesc('created_at')
                                    ->get(['id', 'title']);

                                $links = $galleries->map(function ($g) {
                                    $url = route('filament.admin.resources.galleries.edit', $g->id);
                                    return "<a href=\"{$url}\" target=\"_blank\" class=\"underline font-medium hover:text-warning-700\">✏️ {$g->title}</a>";
                                })->implode('<br>');

                                return new HtmlString("
                                    <div class='rounded-xl border border-warning-300 bg-warning-50 p-4 space-y-2'>
                                        <p class='text-sm font-semibold text-warning-800'>⚠️ Negara <strong>{$category}</strong> sudah memiliki dokumentasi:</p>
                                        <div class='text-xs text-warning-700 space-y-1'>{$links}</div>
                                        <p class='text-xs text-warning-600 mt-1'>Anda tetap bisa melanjutkan untuk menambah dokumentasi baru pada negara ini.</p>
                                    </div>
                                ");
                            })
                            ->visible(fn (Get $get): bool => (bool) $get('_country_has_data'))
                            ->columnSpanFull(),
                    ]),

                // Hidden field to track country data state
                \Filament\Forms\Components\Hidden::make('_country_has_data')
                    ->default(false),

                // ── Langkah 2: Dokumentasi (Repeater) ────────────────────────
                Section::make('Daftar Dokumentasi')
                    ->description('Tambahkan satu atau beberapa dokumentasi sekaligus untuk negara yang dipilih di atas.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Repeater::make('documentations')
                            ->label(false)
                            ->addActionLabel('+ Tambah Dokumentasi')
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
                                    ->maxLength(255),

                                FileUpload::make('images')
                                    ->label('Upload Foto')
                                    ->helperText('Bisa memilih beberapa foto sekaligus.')
                                    ->multiple()
                                    ->reorderable()
                                    ->image()
                                    ->directory('galleries')
                                    ->imageResizeMode('cover')
                                    ->maxFiles(30)
                                    ->required()
                                    ->columnSpanFull(),

                                Toggle::make('is_featured')
                                    ->label('Highlight')
                                    ->helperText('Tandai sebagai dokumentasi pilihan utama dan ditampilkan dihalaman awal')
                                    ->default(false),

                                Toggle::make('is_active')
                                    ->label('Aktif (Tampilkan di Website)')
                                    ->default(true),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Dokumentasi Baru')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('category', 'asc')
            ->groups([
                Group::make('category')
                    ->label('Negara')
                    ->collapsible(),
            ])
            ->defaultGroup('category')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Cover')
                    ->circular(),

                TextColumn::make('title')
                    ->label('Judul Dokumentasi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(35),

                TextColumn::make('category')
                    ->label('Negara')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('destination')
                    ->label('Destinasi / Kota')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('photos_count')
                    ->label('Jumlah Foto')
                    ->getStateUsing(function (Gallery $record) {
                        $photos = $record->getAllPhotos();
                        $count = count($photos);
                        return $count > 0 ? "{$count} Foto" : '0 Foto';
                    })
                    ->badge()
                    ->color('gray'),

                ToggleColumn::make('is_featured')
                    ->label('Highlight'),

                ToggleColumn::make('is_active')
                    ->label('Aktif'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Filter Negara')
                    ->options(fn () => Country::query()->orderBy('name')->pluck('name', 'name')->toArray()),

                TernaryFilter::make('is_featured')
                    ->label('Highlight / Featured'),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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
            'index'  => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit'   => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
