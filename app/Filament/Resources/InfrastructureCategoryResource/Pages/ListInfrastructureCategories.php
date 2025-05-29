<?php

namespace App\Filament\Resources\InfrastructureCategoryResource\Pages;

use App\Filament\Resources\InfrastructureCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInfrastructureCategories extends ListRecords
{
    protected static string $resource = InfrastructureCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
