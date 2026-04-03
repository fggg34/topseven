<?php

namespace App\Filament\Resources\TourEnquiries\Pages;

use App\Filament\Resources\TourEnquiries\TourEnquiryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTourEnquiry extends ViewRecord
{
    protected static string $resource = TourEnquiryResource::class;

    protected static ?string $title = 'Tour enquiry';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
