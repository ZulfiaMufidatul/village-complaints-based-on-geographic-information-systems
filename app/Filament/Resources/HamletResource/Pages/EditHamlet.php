<?php

namespace App\Filament\Resources\HamletResource\Pages;

use App\Filament\Resources\HamletResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHamlet extends EditRecord
{
    protected static string $resource = HamletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus'),
        ];
    }

    public function getTitle(): string
    {
        return 'Ubah Data Dusun';
    }

    public function getBreadcrumb(): string
    {
        return 'Ubah';
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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
