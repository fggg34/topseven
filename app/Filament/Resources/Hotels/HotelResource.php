<?php

namespace App\Filament\Resources\Hotels;

use App\Filament\Resources\Hotels\Pages\ManageHotels;
use App\Models\Hotel;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;

    protected static ?string $navigationLabel = 'Hotels & resorts';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static string|\UnitEnum|null $navigationGroup = 'Destinations';

    protected static ?int $navigationSort = 2;

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
                Select::make('country_id')
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Destination (country)')
                    ->helperText('Optional. Helps organize properties by destination.'),
                Select::make('classification')
                    ->options([
                        Hotel::CLASSIFICATION_HOTEL => 'Hotel',
                        Hotel::CLASSIFICATION_RESORT => 'Resort',
                    ])
                    ->required()
                    ->default(Hotel::CLASSIFICATION_HOTEL),
                Toggle::make('is_active')
                    ->default(true),
                RichEditor::make('description')
                    ->label('Description')
                    ->columnSpanFull(),
                FileUpload::make('featured_image')
                    ->label('Featured image')
                    ->image()
                    ->disk('public')
                    ->directory('hotels')
                    ->visibility('public')
                    ->imagePreviewHeight('260')
                    ->panelAspectRatio('16/10')
                    ->panelLayout('integrated')
                    ->helperText('Main image for this property on the tour page.')
                    ->columnSpanFull(),
                FileUpload::make('gallery')
                    ->label('Gallery')
                    ->image()
                    ->disk('public')
                    ->directory('hotels/gallery')
                    ->visibility('public')
                    ->multiple()
                    ->reorderable()
                    ->maxFiles(12)
                    ->imagePreviewHeight('120')
                    ->panelLayout('grid')
                    ->helperText('Up to 12 images.')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->disk('public')
                    ->circular()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('classification')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Hotel::CLASSIFICATION_RESORT => 'Resort',
                        default => 'Hotel',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        Hotel::CLASSIFICATION_RESORT => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('country.name')
                    ->label('Destination')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
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
            'index' => ManageHotels::route('/'),
        ];
    }
}
