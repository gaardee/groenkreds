<?php

namespace App\Filament\Resources\Aktiviteter\Pages;

use App\Filament\Resources\Aktiviteter\AktivitetResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAktivitet extends EditRecord
{
    protected static string $resource = AktivitetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
