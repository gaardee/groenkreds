<?php

namespace App\Filament\Resources\Kredse\Pages;

use App\Filament\Resources\Kredse\KredsResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateKreds extends CreateRecord
{
    protected static string $resource = KredsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // The key is the secret part of the kreds' own edit link.
        $data['key'] = (string) Str::uuid();

        return $data;
    }
}
