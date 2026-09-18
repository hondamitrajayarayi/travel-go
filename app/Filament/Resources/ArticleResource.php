<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Manajemen Travel';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Artikel & Edukasi';

    protected static ?string $pluralModelLabel = 'Artikel & Edukasi';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Utama Artikel')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Artikel')
                            ->placeholder('Contoh: Panduan Lengkap Syarat & Cara Pengajuan Visa Jepang')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(Article::class, 'slug', ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('category')
                            ->label('Kategori Artikel')
                            ->options([
                                'Info Visa'       => 'Info Visa',
                                'Tips Tour'       => 'Tips Tour',
                                'Panduan Travel'  => 'Panduan Travel',
                                'Destinasi'       => 'Destinasi Wisata',
                            ])
                            ->default('Tips Tour')
                            ->required(),

                        TextInput::make('author')
                            ->label('Penulis / Author')
                            ->default('Tim TravelGo')
                            ->required(),

                        TextInput::make('reading_time')
                            ->label('Estimasi Waktu Baca')
                            ->default('5 min baca')
                            ->placeholder('Contoh: 5 min baca'),

                        DatePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now()),

                        FileUpload::make('thumbnail')
                            ->label('Foto Thumbnail Artikel')
                            ->image()
                            ->directory('articles/thumbnails')
                            ->columnSpanFull(),

                        Textarea::make('excerpt')
                            ->label('Ringkasan Singkat (Excerpt)')
                            ->rows(3)
                            ->placeholder('Ringkasan singkat artikel yang akan tampil di halaman depan...')
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Isi Lengkap Artikel')
                            ->required()
                            ->columnSpanFull(),

                        Toggle::make('is_published')
                            ->label('Publikasikan Artikel')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('🔍 SEO – Optimasi Halaman Artikel')
                    ->description('Pengaturan ini mengontrol bagaimana artikel muncul di Google dan saat link dibagikan ke WhatsApp / Facebook.')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title (Judul SEO)')
                            ->placeholder('Kosongkan untuk otomatis pakai judul artikel')
                            ->maxLength(70)
                            ->helperText('Judul di tab browser & hasil pencarian Google. Idealnya 50–70 karakter. Otomatis dari judul artikel jika dikosongkan.')
                            ->nullable()
                            ->columnSpanFull(),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->placeholder('Deskripsi singkat artikel untuk Google...')
                            ->rows(3)
                            ->maxLength(165)
                            ->helperText('Muncul di hasil pencarian Google. Idealnya 120–160 karakter. Otomatis dari excerpt artikel jika dikosongkan.')
                            ->nullable()
                            ->columnSpanFull(),

                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->placeholder('visa jepang, cara apply visa, tips wisata jepang')
                            ->helperText('Kata kunci relevan, dipisahkan koma. Contoh: visa jepang, cara apply visa, tips wisata.')
                            ->nullable()
                            ->columnSpanFull(),

                        TextInput::make('og_image')
                            ->label('Open Graph Image URL (Thumbnail Share WA/FB)')
                            ->placeholder('https://...')
                            ->url()
                            ->helperText('URL gambar 1200×630px untuk thumbnail saat link artikel dibagikan di WhatsApp/Facebook. Kosong = pakai foto thumbnail artikel.')
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(),
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
                    ->label('Judul Artikel')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Info Visa'      => 'warning',
                        'Tips Tour'      => 'info',
                        'Panduan Travel' => 'success',
                        default          => 'primary',
                    })
                    ->sortable(),

                TextColumn::make('author')
                    ->label('Penulis')
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Dipublikasi'),

                TextColumn::make('published_at')
                    ->label('Tgl Rilis')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Info Visa'       => 'Info Visa',
                        'Tips Tour'       => 'Tips Tour',
                        'Panduan Travel'  => 'Panduan Travel',
                        'Destinasi'       => 'Destinasi Wisata',
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
            'index'  => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit'   => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
