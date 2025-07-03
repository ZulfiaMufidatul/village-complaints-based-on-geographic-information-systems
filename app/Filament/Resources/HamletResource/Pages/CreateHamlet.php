<?php

namespace App\Filament\Resources\HamletResource\Pages;

use App\Filament\Resources\HamletResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHamlet extends CreateRecord
{
    protected static string $resource = HamletResource::class;
    protected static ?string $title = 'Tambah Dusun';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
