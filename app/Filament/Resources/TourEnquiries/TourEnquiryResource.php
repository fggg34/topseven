<?php

namespace App\Filament\Resources\TourEnquiries;

use App\Filament\Resources\TourEnquiries\Pages\ListTourEnquiries;
use App\Filament\Resources\TourEnquiries\Pages\ViewTourEnquiry;
use App\Models\TourEnquiry;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TourEnquiryResource extends Resource
{
    protected static ?string $model = TourEnquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static string|\UnitEnum|null $navigationGroup = 'Enquiries';

    protected static ?string $navigationLabel = 'Tour enquiries';

    protected static ?int $navigationSort = 20;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['tour', 'user']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Package & submission')
                    ->description('What was enquired about and when it was received.')
                    ->schema([
                        TextEntry::make('tour.title')
                            ->label('Travel package')
                            ->placeholder('—'),
                        TextEntry::make('user.name')
                            ->label('Logged-in account')
                            ->placeholder('Guest (submitted without account)'),
                        TextEntry::make('created_at')
                            ->label('Submitted at')
                            ->dateTime(),
                        TextEntry::make('status')
                            ->label('Workflow status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'new' => 'New',
                                'contacted' => 'Contacted',
                                'confirmed' => 'Confirmed',
                                'cancelled' => 'Cancelled',
                                default => ucfirst($state),
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'new' => 'info',
                                'contacted' => 'warning',
                                'confirmed' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Guest details')
                    ->description('Contact information exactly as entered on the form.')
                    ->schema([
                        TextEntry::make('full_name')
                            ->label('Full name'),
                        TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),
                        TextEntry::make('phone')
                            ->label('Phone')
                            ->placeholder('—'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Trip preferences')
                    ->schema([
                        TextEntry::make('departure_date')
                            ->label('Departure date')
                            ->date()
                            ->placeholder('—'),
                        TextEntry::make('return_date')
                            ->label('Return date')
                            ->date()
                            ->placeholder('—'),
                        TextEntry::make('guests')
                            ->label('Guests')
                            ->numeric(),
                        TextEntry::make('estimated_total_display')
                            ->label('Estimated total')
                            ->getStateUsing(function (TourEnquiry $record): string {
                                $total = $record->estimatedTotal();
                                if ($total === null) {
                                    return '— (package price on request)';
                                }
                                $tour = $record->tour;
                                $currency = ($tour?->currency === 'EUR' || ! $tour?->currency) ? '€' : (($tour?->currency === 'USD') ? '$' : $tour->currency.' ');

                                return $currency.number_format($total, $total != floor($total) ? 2 : 0).' (from price × guests)';
                            }),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Message')
                    ->description('Optional note from the customer.')
                    ->schema([
                        TextEntry::make('message')
                            ->label('')
                            ->placeholder('No message provided.')
                            ->prose()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make('Technical')
                    ->schema([
                        TextEntry::make('ip_address')
                            ->label('IP address')
                            ->placeholder('—')
                            ->copyable(),
                    ])
                    ->collapsed()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tour.title')
                    ->label('Package')
                    ->limit(40)
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Account')
                    ->placeholder('Guest')
                    ->searchable(),
                TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('phone')
                    ->placeholder('—'),
                TextColumn::make('guests')
                    ->label('Guests'),
                TextColumn::make('estimated')
                    ->label('Est. total')
                    ->getStateUsing(function (TourEnquiry $record): string {
                        $total = $record->estimatedTotal();
                        if ($total === null) {
                            return '—';
                        }
                        $tour = $record->tour;
                        $currency = ($tour?->currency === 'EUR' || ! $tour?->currency) ? '€' : (($tour->currency === 'USD') ? '$' : $tour->currency.' ');

                        return $currency.number_format($total, $total != floor($total) ? 2 : 0);
                    }),
                TextColumn::make('departure_date')
                    ->date()
                    ->placeholder('—'),
                TextColumn::make('return_date')
                    ->date()
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'info',
                        'contacted' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
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
            'index' => ListTourEnquiries::route('/'),
            'view' => ViewTourEnquiry::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }
}
