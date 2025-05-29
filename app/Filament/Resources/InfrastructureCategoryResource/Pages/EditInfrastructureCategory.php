<?php

namespace App\Filament\Resources\InfrastructureCategoryResource\Pages;

use App\Filament\Resources\InfrastructureCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInfrastructureCategory extends EditRecord
{
    protected static string $resource = InfrastructureCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    // redirect ke index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
