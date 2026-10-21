<?php

namespace App\Filament\Resources\Brugere\Pages;

use App\Filament\Resources\Brugere\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
