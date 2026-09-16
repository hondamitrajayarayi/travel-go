<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Pengaturan Web';

    protected static ?string $navigationLabel = 'Pengaturan Kontak & Sosmed';

    protected static ?string $modelLabel = 'Pengaturan';

    protected static ?string $pluralModelLabel = 'Pengaturan Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ubah Nilai Pengaturan')
                    ->schema([
                        TextInput::make('label')
                            ->label('Nama Pengaturan')
                            ->disabled()
                            ->columnSpan(1),

                        TextInput::make('key')
                            ->label('Key / Kunci Sistem')
                            ->disabled()
                            ->columnSpan(1),

                        TextInput::make('group')
                            ->label('Kategori')
                            ->disabled()
                            ->columnSpan(1),

                        TextInput::make('description')
                            ->label('Keterangan Panduan')
                            ->disabled()
                            ->columnSpan(1),

                        Textarea::make('value')
                            ->label('Isi Nilai (Value)')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText(fn (Setting $record): ?string => $record->description),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Pengaturan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Setting $record): ?string => $record->description),

                TextColumn::make('value')
                    ->label('Nilai Saat Ini')
                    ->searchable()
                    ->wrap()
                    ->limit(60)
                    ->color('primary')
                    ->weight('medium'),

                TextColumn::make('group')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Kontak'               => 'success',
                        'Media Sosial'         => 'warning',
                        'Alamat & Operasional' => 'info',
                        'Rekening Bank'        => 'danger',
                        default                => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('group', 'asc')
            ->defaultGroup('group')
            ->filters([
                SelectFilter::make('group')
                    ->label('Filter Kategori')
                    ->options([
                        'Kontak'               => 'Kontak',
                        'Media Sosial'         => 'Media Sosial',
                        'Alamat & Operasional' => 'Alamat & Operasional',
                        'Rekening Bank'        => 'Rekening Bank',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit Nilai'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit'  => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
