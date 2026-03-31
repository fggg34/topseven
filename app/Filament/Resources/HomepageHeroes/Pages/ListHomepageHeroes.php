<?php

namespace App\Filament\Resources\HomepageHeroes\Pages;

use App\Filament\Resources\HomepageHeroes\HomepageHeroResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHomepageHeroes extends ListRecords
{
    protected static string $resource = HomepageHeroResource::class;

    protected static ?string $title = 'Homepage';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Add slide'),
        ];
    }
}
