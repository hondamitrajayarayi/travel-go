<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Manajemen Travel';

    protected static ?string $navigationLabel = 'Pesan Masuk';

    protected static ?string $modelLabel = 'Pesan Kontak';

    protected static ?string $pluralModelLabel = 'Pesan Kontak Masuk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengirim')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Pengirim')
                            ->disabled(),

                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->disabled(),

                        TextInput::make('phone')
                            ->label('Nomor WhatsApp / Telp')
                            ->disabled(),

                        TextInput::make('subject')
                            ->label('Subjek Pesan')
                            ->disabled(),

                        Textarea::make('message')
                            ->label('Isi Pesan')
                            ->rows(5)
                            ->columnSpanFull()
                            ->disabled(),
                    ])
                    ->columns(2),

                Section::make('Status & Tindak Lanjut Admin')
                    ->schema([
                        Select::make('status')
                            ->label('Status Pesan')
                            ->options([
                                'unread'  => 'Belum Dibaca',
                                'read'    => 'Sudah Dibaca',
                                'replied' => 'Sudah Dibalas / Dihubungi',
                            ])
                            ->default('unread')
                            ->required(),

                        Textarea::make('notes')
                            ->label('Catatan Internal Admin')
                            ->placeholder('Tambahkan catatan tindak lanjut di sini...')
                            ->rows(3),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->tooltip('Klik untuk menyalin email'),

                TextColumn::make('phone')
                    ->label('WhatsApp / Telp')
                    ->searchable()
                    ->copyable()
                    ->url(fn (?string $state): ?string => $state ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $state) : null, true),

                TextColumn::make('subject')
                    ->label('Subjek')
                    ->limit(30)
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unread'  => 'danger',
                        'read'    => 'warning',
                        'replied' => 'success',
                        default   => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'unread'  => 'Belum Dibaca',
                        'read'    => 'Sudah Dibaca',
                        'replied' => 'Sudah Dibalas',
                        default   => $state,
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'unread'  => 'Belum Dibaca',
                        'read'    => 'Sudah Dibaca',
                        'replied' => 'Sudah Dibalas',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->label('Ubah Status'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'edit'  => Pages\EditContact::route('/{record}/edit'),
            'view'  => Pages\ViewContact::route('/{record}'),
        ];
    }
}
