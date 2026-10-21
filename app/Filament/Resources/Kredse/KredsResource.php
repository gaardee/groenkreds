<?php

namespace App\Filament\Resources\Kredse;

use App\Filament\Resources\Kredse\Pages\CreateKreds;
use App\Filament\Resources\Kredse\Pages\EditKreds;
use App\Filament\Resources\Kredse\Pages\ListKreds;
use App\Models\Kreds;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KredsResource extends Resource
{
    protected static ?string $model = Kreds::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $recordTitleAttribute = 'navn';

    protected static ?string $slug = 'kredse';

    protected static ?string $modelLabel = 'Kreds';

    protected static ?string $pluralModelLabel = 'Kredse';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kreds')
                    ->schema([
                        Toggle::make('active')
                            ->label('Aktiv'),

                        TextInput::make('navn')
                            ->label('Navn')
                            ->required()
                            ->maxLength(255),

                        TextEntry::make('kreds_side')
                            ->label('Kreds side')
                            ->state(fn (Kreds $record): string => url("/kreds/{$record->key}"))
                            ->url(fn (Kreds $record): string => url("/kreds/{$record->key}"))
                            ->openUrlInNewTab()
                            ->visible(fn (?Kreds $record): bool => filled($record?->key)),
                    ]),

                Section::make('Lokation')
                    ->columns(2)
                    ->schema([
                        TextInput::make('latitude')
                            ->label('Breddegrad')
                            ->numeric()
                            ->minValue(-90)
                            ->maxValue(90),

                        TextInput::make('longitude')
                            ->label('Længdegrad')
                            ->numeric()
                            ->minValue(-180)
                            ->maxValue(180),

                        TextEntry::make('kort')
                            ->label('Vis på kort')
                            ->state('Åbn i Google Maps')
                            ->url(fn (?Kreds $record): ?string => $record?->latitude && $record?->longitude
                                ? "https://www.google.com/maps?q={$record->latitude},{$record->longitude}"
                                : null)
                            ->openUrlInNewTab()
                            ->visible(fn (?Kreds $record): bool => $record?->latitude && $record?->longitude),
                    ]),

                Section::make('Kontaktperson')
                    ->columns(3)
                    ->schema([
                        TextInput::make('kontakt_navn')
                            ->label('Navn'),

                        TextInput::make('kontakt_email')
                            ->label('Email')
                            ->email(),

                        TextInput::make('kontakt_telefon')
                            ->label('Telefon')
                            ->tel(),
                    ]),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('navn')
            ->defaultSort('navn')
            ->columns([
                ToggleColumn::make('active')
                    ->label('Aktiv')
                    ->sortable(),

                TextColumn::make('navn')
                    ->label('Navn')
                    ->searchable(['navn', 'key'])
                    ->sortable(),

                TextColumn::make('key')
                    ->label('Kreds side')
                    ->formatStateUsing(fn (): string => 'Åbn kreds side')
                    ->url(fn (Kreds $record): string => url("/kreds/{$record->key}"))
                    ->openUrlInNewTab(),
            ])
            ->filters([
                TernaryFilter::make('active')
                    ->label('Aktiv'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKreds::route('/'),
            'create' => CreateKreds::route('/create'),
            'edit' => EditKreds::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
