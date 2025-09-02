<?php

namespace App\Filament\Resources\RTResource\Pages;

use App\Filament\Resources\RTResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditRT extends EditRecord
{
    protected static string $resource = RTResource::class;

    public function getTitle(): string
    {
        return 'Ubah Data RT';
    }

    public function getBreadcrumb(): string
    {
        return 'Ubah';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading('Hapus RT'),
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(RTResource::getUrl('index'))
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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
