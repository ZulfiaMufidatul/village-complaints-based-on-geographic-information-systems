<?php

namespace App\Filament\Resources\InfrastructureCategoryResource\Pages;

use App\Filament\Resources\InfrastructureCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInfrastructureCategory extends CreateRecord
{
    protected static string $resource = InfrastructureCategoryResource::class;

    // redirect ke index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
