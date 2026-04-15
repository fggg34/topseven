<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\TourEnquiries\TourEnquiryResource;
use App\Models\TourEnquiry;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestTourEnquiriesWidget extends TableWidget
{
    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = false;

    public static function canView(): bool
    {
        return TourEnquiryResource::canViewAny();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TourEnquiry::query()
                    ->with(['tour', 'user'])
            )
            ->heading('Latest tour enquiries')
            ->description('Most recent submissions; open a row for full details.')
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(8)
            ->paginationPageOptions([5, 8, 15])
            ->columns([
                TextColumn::make('tour.title')
                    ->label('Package')
                    ->limit(40)
                    ->placeholder('—')
                    ->weight('medium'),
                TextColumn::make('full_name')
                    ->label('Guest')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('guests')
                    ->label('Pax')
                    ->alignCenter(),
                TextColumn::make('status')
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
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable(),
            ])
            ->headerActions([
                Action::make('viewAll')
                    ->label('View all enquiries')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->url(TourEnquiryResource::getUrl()),
            ])
            ->recordActions([
                ViewAction::make()
                    ->modal(false)
                    ->url(fn (TourEnquiry $record): string => TourEnquiryResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
