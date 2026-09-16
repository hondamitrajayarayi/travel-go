<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
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

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Manajemen Travel';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Banner Hero';

    protected static ?string $pluralModelLabel = 'Banner Hero';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Gambar & Target Tampilan Banner')
                    ->description('Upload banner gambar dan tentukan target tampilan (Desktop Web atau Layar Mobile HP).')
                    ->schema([
                        Select::make('placement')
                            ->label('Target Tampilan')
                            ->options([
                                'all'     => '📱💻 Semua Perangkat (Desktop Web & Mobile HP)',
                                'desktop' => '💻 Khusus Web Desktop / Laptop (2524 x 1424 px)',
                                'mobile'  => '📱 Khusus Layar Mobile HP (3456 x 5184 px)',
                            ])
                            ->default('all')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Pilih target perangkat banner. Anda dapat membuat banner berbeda untuk ukuran Web Desktop maupun Mobile HP.'),

                        FileUpload::make('image_path')
                            ->label('Upload Gambar Banner')
                            ->image()
                            ->directory('banners/images')
                            ->required()
                            ->imageEditor()
                            ->columnSpanFull()
                            ->helperText('Format: JPG, PNG, atau WEBP. 💡 Ukuran Ideal: Web Desktop (2524 x 1424 px) | Mobile HP (3456 x 5184 px)'),
                    ]),

                Section::make('Teks & Pengaturan Banner')
                    ->description('Atur teks overlay, link CTA, serta urutan banner.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Banner (Opsional)')
                            ->maxLength(255)
                            ->placeholder('Contoh: Liburan Impian Tanpa Ribet'),

                        Textarea::make('subtitle')
                            ->label('Subjudul / Deskripsi (Opsional)')
                            ->rows(3)
                            ->placeholder('Contoh: Jelajahi destinasi wisata terbaik bersama Super Vacation...'),

                        TextInput::make('button_text')
                            ->label('Teks Tombol CTA (Opsional)')
                            ->placeholder('Contoh: Lihat Paket Tour'),

                        TextInput::make('link_url')
                            ->label('URL Link Tombol (Opsional)')
                            ->placeholder('https://wa.me/... atau #tours'),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Foto Banner')
                    ->square()
                    ->defaultImageUrl(fn ($record) => $record?->file_path ? asset('storage/' . $record->file_path) : null),

                TextColumn::make('placement')
                    ->label('Target Tampilan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'all'     => 'info',
                        'desktop' => 'primary',
                        'mobile'  => 'warning',
                        default   => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'all'     => '📱💻 Semua Perangkat',
                        'desktop' => '💻 Web Desktop (2524x1424)',
                        'mobile'  => '📱 Mobile HP (3456x5184)',
                        default   => $state,
                    }),

                TextColumn::make('title')
                    ->label('Judul Banner')
                    ->searchable()
                    ->sortable()
                    ->default('-'),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Status Aktif'),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('placement')
                    ->label('Target Perangkat')
                    ->options([
                        'all'     => '📱💻 Semua Perangkat',
                        'desktop' => '💻 Web Desktop Saja',
                        'mobile'  => '📱 Mobile HP Saja',
                    ]),
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
            'index'  => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit'   => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
