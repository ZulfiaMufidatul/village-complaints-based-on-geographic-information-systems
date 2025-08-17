<?php

namespace App\Filament\Resources\InfrastructureCategoryResource\Pages;

use App\Filament\Resources\InfrastructureCategoryResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditInfrastructureCategory extends EditRecord
{
    protected static string $resource = InfrastructureCategoryResource::class;

    public function getTitle(): string
    {
        return 'Ubah Data Kategori Infrastruktur';
    }

    public function getBreadcrumb(): string
    {
        return 'Ubah';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(InfrastructureCategoryResource::getUrl('index'))
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),
            Actions\Action::make('cancel')
                ->label('Batal')
                ->color('gray')
                ->outlined()
                ->url($this->getResource()::getUrl('index')),
        ];
    }
    
    // redirect ke index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
