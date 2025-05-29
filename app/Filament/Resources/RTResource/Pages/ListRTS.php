<?php

namespace App\Filament\Resources\RTResource\Pages;

use App\Filament\Resources\RTResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRTS extends ListRecords
{
    protected static string $resource = RTResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
