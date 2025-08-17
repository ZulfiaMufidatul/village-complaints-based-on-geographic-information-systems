<?php

namespace App\Filament\Resources\InfrastructureCategoryResource\Pages;

use App\Filament\Resources\InfrastructureCategoryResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateInfrastructureCategory extends CreateRecord
{
    protected static string $resource = InfrastructureCategoryResource::class;
    protected static ?string $title = 'Tambah Kategori Infrastruktur';
    // redirect ke index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(InfrastructureCategoryResource::getUrl('index'))
        ];
    }
}
