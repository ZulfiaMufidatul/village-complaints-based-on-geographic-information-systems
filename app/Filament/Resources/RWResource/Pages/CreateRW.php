<?php

namespace App\Filament\Resources\RWResource\Pages;

use App\Filament\Resources\RWResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateRW extends CreateRecord
{
    protected static string $resource = RWResource::class;
    protected static ?string $title = 'Tambah RW';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(RWResource::getUrl('index'))
        ];
    }
    // redirect ke index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
