<?php

namespace App\Filament\Resources\TourEnquiries;

use App\Filament\Resources\TourEnquiries\Pages\EditTourEnquiry;
use App\Filament\Resources\TourEnquiries\Pages\ListTourEnquiries;
use App\Models\TourEnquiry;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
        return $schema
            ->components([
                Section::make('Enquiry')
                    ->description(fn (?TourEnquiry $record) => $record ? ($record->tour?->title ?? 'Travel package') . ' · ' . $record->full_name . ' · ' . $record->email : null)
                    ->schema([
                        Select::make('status')
                            ->options([
                                'new' => 'New',
                                'contacted' => 'Contacted',
                                'confirmed' => 'Confirmed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        Textarea::make('message')
                            ->label('Customer message')
                            ->rows(8)
                            ->columnSpanFull(),
                    ]),
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
            'index' => ListTourEnquiries::route('/'),
            'edit' => EditTourEnquiry::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
