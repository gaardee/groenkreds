<?php

namespace App\Filament\Resources\Aktiviteter\Pages;

use App\Filament\Resources\Aktiviteter\AktivitetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAktiviteter extends ListRecords
{
    protected static string $resource = AktivitetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
