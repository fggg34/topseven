<?php

namespace App\Filament\Resources\Tours\Schemas;

use App\Models\Tour;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class TourForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tour')
                    ->tabs([
                        Tab::make('Overview')
                            ->schema([
                                Section::make('Main information')
                                    ->schema([
                                        Select::make('category_id')
                                            ->relationship('category', 'name')
                                            ->required(),
                                        Select::make('countries')
                                            ->relationship('countries', 'name')
                                            ->multiple()
                                            ->searchable()
                                            ->preload()
                                            ->label('Countries'),
                                        Select::make('hotels')
                                            ->relationship('hotels', 'name')
                                            ->multiple()
                                            ->searchable()
                                            ->preload()
                                            ->label('Hotels & resorts'),
                                        TextInput::make('title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (?string $state, Set $set, ?Model $record) {
                                                $title = $state ?? '';
                                                if ($title === '') {
                                                    $set('slug', '');

                                                    return;
                                                }
                                                $exceptId = $record instanceof Tour ? $record->getKey() : null;
                                                $set('slug', Tour::uniqueSlugFromTitle($title, $exceptId));
                                            }),
                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Filled from the title; you can change it. Must be unique among tours.'),
                                        Textarea::make('short_description')
                                            ->rows(4)
                                            ->maxLength(65535)
                                            ->columnSpanFull()
                                            ->helperText('Plain-text summary for listings and cards (up to ~64KB).'),
                                        RichEditor::make('description')->label('Description')->columnSpanFull(),
                                    ])
                                    ->columns(2),
                                Section::make('Pricing')
                                    ->schema([
                                        TextInput::make('base_price')->numeric()->default(0)->prefix('€')->required()->label('Base price (per person, fallback when no tier matches)'),
                                        Repeater::make('pricingTiers')
                                            ->relationship()
                                            ->schema([
                                                TextInput::make('min_people')->numeric()->required()->minValue(1)->suffix('persons'),
                                                TextInput::make('max_people')->numeric()->nullable()->minValue(1)->placeholder('Leave empty for 9+'),
                                                TextInput::make('price_per_person')->numeric()->required()->prefix('€'),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->reorderableWithButtons()
                                            ->label('Group pricing tiers')
                                            ->helperText('e.g. 1-1: 80€, 2-4: 60€, 5-8: 50€, 9+: 45€'),
                                        Repeater::make('discounts')
                                            ->relationship()
                                            ->schema([
                                                \Filament\Forms\Components\DatePicker::make('start_date')->required()->label('Start date'),
                                                \Filament\Forms\Components\DatePicker::make('end_date')->required()->label('End date'),
                                                Select::make('discount_type')
                                                    ->options(['fixed' => 'Fixed amount (€)', 'percent' => 'Percentage (%)'])
                                                    ->required()
                                                    ->default('fixed'),
                                                TextInput::make('discount_value')->numeric()->required()->minValue(0),
                                                TextInput::make('label')->placeholder('e.g. Early bird')->label('Label (optional)'),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->reorderableWithButtons()
                                            ->label('Date-based discounts')
                                            ->helperText('Discounts for specific date ranges. First matching discount is applied when a date is selected.'),
                                    ])
                                    ->columns(1),
                                Section::make('Visibility & order')
                                    ->schema([
                                        Toggle::make('is_featured')->default(false),
                                        Toggle::make('is_active')->default(true),
                                        TextInput::make('sort_order')->numeric()->default(0),
                                    ])
                                    ->columns(3),
                                Section::make('Homepage featured tours slider')
                                    ->description('When this tour is added under Pages → Homepage → Featured tours, these dates appear on the white badge on the homepage card. Leave empty to hide the badge.')
                                    ->schema([
                                        DatePicker::make('homepage_card_date_from')
                                            ->label('Date from')
                                            ->native(false)
                                            ->displayFormat('d M Y')
                                            ->live(),
                                        DatePicker::make('homepage_card_date_to')
                                            ->label('Date to')
                                            ->native(false)
                                            ->displayFormat('d M Y')
                                            ->minDate(fn (Get $get) => $get('homepage_card_date_from') ? \Carbon\Carbon::parse($get('homepage_card_date_from')) : null),
                                    ])
                                    ->columns(2),
                            ]),
                        Tab::make('Images')
                            ->schema([
                                Section::make('Gallery')
                                    ->description('Add images for this tour. Drag rows to change display order.')
                                    ->schema([
                                        Repeater::make('images')
                                            ->relationship()
                                            ->orderColumn('sort_order')
                                            ->schema([
                                                FileUpload::make('path')
                                                    ->label('Image')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('tour-images')
                                                    ->visibility('public')
                                                    ->imagePreviewHeight('200')
                                                    ->panelAspectRatio('4/3')
                                                    ->panelLayout('integrated')
                                                    ->required(),
                                                TextInput::make('alt')->maxLength(255),
                                                TextInput::make('sort_order')->numeric()->default(0),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(0)
                                            ->reorderable()
                                            ->reorderableWithDragAndDrop()
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Included')
                            ->schema([
                                Section::make('What\'s included')
                                    ->schema([
                                        TagsInput::make('included')
                                            ->placeholder('Add item (e.g. Guide, Transport)')
                                            ->splitKeys(['Tab', 'Enter']),
                                    ]),
                            ]),
                        Tab::make('SEO')
                            ->schema([
                                Section::make('Search engine optimization')
                                    ->description('Optional. Leave blank to use the tour title and short description.')
                                    ->schema([
                                        TextInput::make('meta_title')->maxLength(60)->columnSpanFull(),
                                        Textarea::make('meta_description')->rows(3)->maxLength(500)->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
