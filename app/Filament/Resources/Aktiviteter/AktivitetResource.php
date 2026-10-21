<?php

namespace App\Filament\Resources\Aktiviteter;

use App\Filament\Resources\Aktiviteter\Pages\CreateAktivitet;
use App\Filament\Resources\Aktiviteter\Pages\EditAktivitet;
use App\Filament\Resources\Aktiviteter\Pages\ListAktiviteter;
use App\Models\Aktivitet;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class AktivitetResource extends Resource
{
    protected static ?string $model = Aktivitet::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $slug = 'aktiviteter';

    protected static ?string $modelLabel = 'Aktivitet';

    protected static ?string $pluralModelLabel = 'Aktiviteter';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Type')
                    ->options(Aktivitet::TYPES)
                    ->required(),

                TextInput::make('title')
                    ->label('Titel')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, string $operation) {
                        if ($operation === 'create' || blank($get('slug'))) {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->alphaDash()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('ikon')
                    ->label('Ikon')
                    ->placeholder('fas fa-tree')
                    ->helperText(new HtmlString('Font Awesome 5 klasse, fx <code>fas fa-tree</code>. Find ikoner på <a href="https://fontawesome.com/v5/search?m=free" target="_blank" class="underline">fontawesome.com</a>.'))
                    ->live(onBlur: true)
                    ->hint(fn (?string $state): ?HtmlString => filled($state)
                        ? new HtmlString('<i class="'.e($state).'" style="font-size: 1.5rem"></i>')
                        : null),

                FileUpload::make('path')
                    ->label('Billede')
                    ->image()
                    ->disk('public')
                    ->imageEditor()
                    ->imageAspectRatio('16:9')
                    ->automaticallyCropImagesToAspectRatio()
                    ->automaticallyResizeImagesToWidth('1920'),

                RichEditor::make('indhold')
                    ->label('Indhold')
                    ->columnSpanFull(),

                RichEditor::make('materialer')
                    ->label('Materialer')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('type')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (?int $state): string => Aktivitet::TYPES[$state] ?? '-')
                    ->color(fn (?int $state): array => Color::hex(Aktivitet::TYPE_COLORS[$state] ?? '#6b7280'))
                    ->sortable(),

                TextColumn::make('ikon')
                    ->label('Ikon')
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '<i class="'.e($state).'"></i>'),

                TextColumn::make('title')
                    ->label('Titel')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('path')
                    ->label('Billede')
                    ->disk('public'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(Aktivitet::TYPES),
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
            'index' => ListAktiviteter::route('/'),
            'create' => CreateAktivitet::route('/create'),
            'edit' => EditAktivitet::route('/{record}/edit'),
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
