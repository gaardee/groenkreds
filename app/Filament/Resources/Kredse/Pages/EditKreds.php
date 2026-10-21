<?php

namespace App\Filament\Resources\Kredse\Pages;

use App\Filament\Resources\Kredse\KredsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditKreds extends EditRecord
{
    protected static string $resource = KredsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
