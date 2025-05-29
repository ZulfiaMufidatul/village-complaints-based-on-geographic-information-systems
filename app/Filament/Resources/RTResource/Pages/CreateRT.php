<?php

namespace App\Filament\Resources\RTResource\Pages;

use App\Filament\Resources\RTResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRT extends CreateRecord
{
    protected static string $resource = RTResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
