<?php

namespace App\Filament\Resources\Kredse\Pages;

use App\Filament\Resources\Kredse\KredsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKreds extends ListRecords
{
    protected static string $resource = KredsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
