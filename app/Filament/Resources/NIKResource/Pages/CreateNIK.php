<?php

namespace App\Filament\Resources\NIKResource\Pages;

use App\Filament\Resources\NIKResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateNIK extends CreateRecord
{
    protected static string $resource = NIKResource::class;
    protected static ?string $title = 'Tambah Data NIK';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(NIKResource::getUrl('index'))
        ];
    }

    // redirect ke index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
