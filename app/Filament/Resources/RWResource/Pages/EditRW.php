<?php

namespace App\Filament\Resources\RWResource\Pages;

use App\Filament\Resources\RWResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditRW extends EditRecord
{
    protected static string $resource = RWResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading('Hapus RW'),
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
