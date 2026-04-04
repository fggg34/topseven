<?php

namespace App\Filament\Resources\Countries;

use App\Filament\Resources\Countries\Pages\ManageCountries;
use App\Models\Country;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationLabel = 'Countries';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|\UnitEnum|null $navigationGroup = 'Destinations';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('iso_alpha2')
                    ->label('ISO country code')
                    ->maxLength(2)
                    ->extraInputAttributes(['class' => 'uppercase', 'style' => 'text-transform:uppercase'])
                    ->unique(ignoreRecord: true)
                    ->helperText('Two-letter code (e.g. AL, IT). Used for data matching and internal references.'),
                TextInput::make('calling_code')
                    ->label('Calling code')
                    ->maxLength(8)
                    ->placeholder('355')
                    ->helperText('Digits only, no +. Optional reference for this destination.'),
                TextInput::make('country')
                    ->label('Region / subtitle')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Shown as a small label under the destination name (e.g. continent or tagline).'),
                Toggle::make('is_active')
                    ->default(true)
                    ->helperText('Inactive countries are hidden from public destination pickers, filters, and the countries index (only active destinations with at least one live tour are listed publicly).'),
                RichEditor::make('description')
                    ->label('Description')
                    ->columnSpanFull(),
                FileUpload::make('city_image')
                    ->label('Hero image')
                    ->image()
                    ->disk('public')
                    ->directory('cities')
                    ->visibility('public')
                    ->imagePreviewHeight('260')
                    ->panelAspectRatio('16/10')
                    ->panelLayout('integrated')
                    ->helperText('Main image shown at the top of the country page.')
                    ->columnSpanFull(),
                FileUpload::make('gallery')
                    ->label('Gallery')
                    ->image()
                    ->disk('public')
                    ->directory('cities/gallery')
                    ->visibility('public')
                    ->multiple()
                    ->reorderable()
                    ->maxFiles(12)
                    ->imagePreviewHeight('120')
                    ->panelLayout('grid')
                    ->helperText('Add multiple images to the gallery (up to 12).')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('city_image')
                    ->disk('public')
                    ->circular()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('iso_alpha2')
                    ->label('ISO')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('calling_code')
                    ->label('Dial')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                TextColumn::make('country')
                    ->label('Region')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tours_count')
                    ->counts('tours')
                    ->label('Tours')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Country $record): string => route('countries.show', $record->slug))
                    ->openUrlInNewTab()
                    ->visible(fn (Country $record): bool => (bool) $record->slug),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCountries::route('/'),
        ];
    }
}
