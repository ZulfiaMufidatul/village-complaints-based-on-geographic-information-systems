<?php

namespace App\Filament\Resources\RTResource\Pages;

use App\Filament\Resources\RTResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRT extends EditRecord
{
    protected static string $resource = RTResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
