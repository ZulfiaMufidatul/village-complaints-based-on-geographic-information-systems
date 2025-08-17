<?php

namespace App\Filament\Resources\HamletResource\Pages;

use App\Filament\Resources\HamletResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateHamlet extends CreateRecord
{
    protected static string $resource = HamletResource::class;
    protected static ?string $title = 'Tambah Dusun';

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
                ->url(HamletResource::getUrl('index'))
        ];
    }
}
