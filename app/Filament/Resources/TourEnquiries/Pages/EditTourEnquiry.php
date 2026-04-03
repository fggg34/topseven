<?php

namespace App\Filament\Resources\TourEnquiries\Pages;

use App\Filament\Resources\TourEnquiries\TourEnquiryResource;
use Filament\Resources\Pages\EditRecord;

class EditTourEnquiry extends EditRecord
{
    protected static string $resource = TourEnquiryResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
